<?php

namespace App\Controllers\main\hrd;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\FileModel;

class FormNumber extends BaseController
{
    protected $fileModel;
    public function __construct()
    {
        $this->fileModel = new FileModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('151');
        $data = [
            't_title' => lang('app.form number'),
            't_span' => lang('app.span form number'),
            'link' => base_url('formnumber'),
            'pHid' => '',
            'form' => $this->mainModel->getForm($this->urls[1], 'iso', '', ''),
        ];
        $this->render('main/hrd/form_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_file', $this->request->getVar('search'), 'u');
            checkPage('151', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->sub_param} ; {$db1[0]->name}");

            $data = [
                't_modal' => lang('app.form number'),
                'link' => base_url('formnumber'),
                'pHid' => '',
                'param' => 'form number',
                'selectGroup' => $this->mainModel->distSelect('numbering', 't'),
                'selectName' => $this->mainModel->distSelect('numbering'),
                'company' => $this->mainModel->getCompany('', 't'),
                'form' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/hrd/form_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_file', $this->request->getVar('unique'));
            $cekData = $this->mainModel->cekData('m_file', 'sub_param', $this->request->getVar('form'), 'company_id', $this->request->getVar('company'), $this->request->getVar('unique'));
            $ruleForm = ($cekData ? 'valid_email' : 'required');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                // $cekLink = $this->mainModel->cekLink('m_item', $field, $db1[0]->id);
                // if ($cekLink) $ruleLink = 'required';
            }

            $validationRules = [
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'code' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'form' => ['rules' => $ruleForm, 'errors' => ['valid_email' => lang("app.err unique")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'form' => $this->validation->getError('form'),
                        'code' => $this->validation->getError('code'),
                    ]
                ];
            } else {
                // Save
                if ($this->request->getVar('postAction') == 'save') {
                    $adaptation = (empty($db1) ? '001' : $db1[0]->adaptation[0] . '0' . $db1[0]->adaptation[2]);
                    $title = (empty($db1) ? lang('app.title create') : lang('app.title edit'));
                    if ($unique == '') $unique = create_Unique();

                    $this->fileModel->save([
                        'id' => $db1[0]->id ?? '',
                        'unique' => $unique,
                        'param' => 'iso',
                        'sub_param' => $this->request->getVar('form'),
                        'name' => strtoupper($this->request->getVar('code')),
                        'company_id' => $this->request->getVar('company'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, $this->request->getVar('form') . ' ; ' . strtoupper($this->request->getVar('code')));
                    $this->session->setFlashdata(['message' => lang('app.' . $this->request->getVar('form')) . ' ; ' . strtoupper($this->request->getVar('code')) . $title]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->fileModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, "{$db1[0]->sub_param} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => lang('app.' . $db1[0]->sub_param) . ' ; ' . $db1[0]->name . lang("app.title confirm")]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->fileModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, "{$db1[0]->sub_param} ; {$db1[0]->name}");
                    $this->session->setFlashdata(['message' => lang('app.' . $db1[0]->sub_param) . ' ; ' . $db1[0]->name . lang("app.title delete")]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->fileModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->sub_param} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => lang('app.' . $db1[0]->sub_param) . " ; {$db1[0]->name} {$result[2]}"]);
                }
                $msg = ['redirect' => '/formnumber'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
