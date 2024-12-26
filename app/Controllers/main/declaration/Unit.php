<?php

namespace App\Controllers\main\declaration;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\FileModel;

class Unit extends BaseController
{
    protected $fileModel;
    public function __construct()
    {
        $this->fileModel = new FileModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('111');
        $data = [
            't_title' => lang('app.unit'),
            't_span' => lang('app.span unit'),
            'link' => '/unit',
            'cHid' => 'hidden',
            'rHid' => 'hidden',
            'unit' => $this->mainModel->getFile($this->urls[1], 'unit'),
        ];
        $this->render('main/declaration/unit_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_file', $this->request->getVar('search'), 'u');
            checkPage('111', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, $db1[0]->name);

            $data = [
                't_modal' => lang('app.unit'),
                'link' => "/unit",
                'company' => [],
                'region' => [],
                'division' => [],
                'cHid' => 'hidden',
                'rHid' => 'hidden',
                'param' => 'unit',
                'file' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => $buttons['delete'], 'active' => $buttons['active']],
                'btn_active' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.btn active') : lang('app.btn inactive')),
                'active_by' => (isset($db1[0]) && $db1[0]->adaptation[2] == '0' ? lang('app.inactive by') : lang('app.active by')),
            ];
            $msg = ['data' => view('main/declaration/unit_input', $data)];
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
            $cekData = $this->mainModel->cekData('m_file', 'name', $this->request->getVar('description'), 'param', 'unit', $this->request->getVar('unique'));
            $ruleName = ($cekData ? 'required|is_unique[m_file.name]' : 'required');
            $unique = $this->request->getVar('unique');

            $ruleLink = 'permit_empty';
            if ($this->request->getVar('postAction') == 'delete') {
                if ($ruleLink !== 'required') cekLink('m_cost', 'unit', $db1[0]->name, $ruleLink);
                if ($ruleLink !== 'required') cekLink('m_item', 'unit', $db1[0]->name, $ruleLink);
            }

            $validationRules = [
                'askDelete' => ['rules' => $ruleLink, 'errors' => ['required' => lang("app.err delete")]],
                'description' => ['rules' => $ruleName, 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'askDelete' => $this->validation->getError('askDelete'),
                        'description' => $this->validation->getError('description'),
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
                        'param' => 'unit',
                        'name' => $this->request->getVar('description'),
                        'adaptation' => $adaptation,
                        'save_by' => $this->user['id'],
                    ]);
                    $this->logModel->saveLog('Save', $unique, $this->request->getVar('description'));
                    $this->session->setFlashdata(['message' => $this->request->getVar('description') . $title]);
                }

                // Confirm
                if ($this->request->getVar('postAction') == 'confirm') {
                    $adaptation = '11' . $db1[0]->adaptation[2];
                    $this->fileModel->save(['id' => $db1[0]->id, 'adaptation' => $adaptation, 'confirm_by' => $this->user['id']]);
                    $this->logModel->saveLog('Confirm', $unique, $db1[0]->name);
                    $this->session->setFlashdata(['message' => $db1[0]->name . lang("app.title confirm")]);
                }

                // Delete
                if ($this->request->getVar('postAction') == 'delete') {
                    $this->fileModel->delete($db1[0]->id);
                    $this->logModel->saveLog('Delete', $unique, $db1[0]->name);
                    $this->session->setFlashdata(['message' => $db1[0]->name . lang("app.title delete")]);
                }

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->fileModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => "{$db1[0]->name} {$result[2]}"]);
                }
                $msg = ['redirect' => '/unit'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
