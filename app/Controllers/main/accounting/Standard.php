<?php

namespace App\Controllers\main\accounting;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\StandardModel;

class Standard extends BaseController
{
    protected $standardModel;
    public function __construct()
    {
        $this->standardModel = new StandardModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('126');
        $data = [
            't_title' => lang('app.other standard'),
            't_span' => lang('app.span other standard'),
            'link' => base_url('otherstandard'),
            'selectCategory' => $this->mainModel->distSelect('standard'),
        ];
        $this->render('main/accounting/standard_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_standard', $this->request->getVar('search'), 'u');
            checkPage('126', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, $db1[0]->name);

            $data = [
                't_modal' => lang('app.other standard'),
                'link' => base_url('otherstandard'),
                'selectCategory' => $this->mainModel->distSelect('standard'),
                'selectGroup' => $this->mainModel->loadGroupAccount('tax', 'income tax'),
                'standard' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/accounting/standard_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_standard', $this->request->getVar('unique'));
            $cekCode1 = $this->mainModel->cekData('m_standard', 'code', $this->request->getVar('code'), 'param', 'code standard', $this->request->getVar('unique'));
            $ruleCode1 = ($cekCode1 ? 'required|is_unique[m_standard.code]|min_length[5]' : 'required|min_length[5]');
            $cekCode2 = $this->mainModel->cekData('m_standard', 'code', $this->request->getVar('code2'), 'param', 'tax object', $this->request->getVar('unique'));
            $ruleCode2 = ($cekCode2 ? 'required|is_unique[m_standard.code]|min_length[9]' : 'required|min_length[9]');
            if ($this->request->getVar('xCategory') != 'code standard') $ruleCode1 = 'permit_empty';
            if ($this->request->getVar('xCategory') != 'tax object') $ruleCode2 = 'permit_empty';
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                if ($ruleLink !== 'required') cekLink('m_project', 'standard_id', $db1[0]->id, $ruleLink);
                if ($ruleLink !== 'required') cekLink('m_tool', 'standard_id', $db1[0]->id, $ruleLink);
                if ($ruleLink !== 'required') cekLink('m_land', 'standard_id', $db1[0]->id, $ruleLink);
            }

            $validationRules = [
                'code' => ['rules' => $ruleCode1, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique"), 'min_length' => lang("app.err length", [5])]],
                'code2' => ['rules' => $ruleCode2, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique"), 'min_length' => lang("app.err length", [9])]],
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'code' => $this->validation->getError('code'),
                        'code2' => $this->validation->getError('code2'),
                        'description' => $this->validation->getError('description'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $code = ($this->request->getVar('xCategory') == 'code standard' ? $this->request->getVar('code') : ($this->request->getVar('xCategory') == 'tax object' ? $this->request->getVar('code2') : ''));
                    $tax = ($this->request->getVar('xCategory') == 'tax object' ? $this->request->getVar('tax') : '');
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    if ($unique == '') $unique = create_Unique();

                    $this->standardModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'param' => $this->request->getVar('xCategory'),
                        'code' => $code,
                        'name' => $this->request->getVar('description'),
                        'tax_id' => $tax,
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => "{$this->request->getVar('description')} {$title}", 'flash-category' => $this->request->getVar('xCategory')]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->accountModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, $db1[0]->name);
                    $this->session->setFlashdata(['message' => $db1[0]->name . lang("app.title confirm"), 'flash-category' => $db1[0]->param]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->accountModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, $db1[0]->name);
                    $this->session->setFlashdata(['message' => $db1[0]->name . lang("app.title delete"), 'flash-category' => $db1[0]->param]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->accountModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->name} {$result[2]}", 'flash-category' => $db1[0]->category]);
                }
                $msg = ['redirect' => '/otherstandard'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function searchData()
    {
        if ($this->request->isAJAX()) {
            $data = ['standard' => $this->mainModel->getStandard($this->urls[1], $this->request->getVar('category'))];
            $msg = ['data' => view('x-main/standard_table', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
