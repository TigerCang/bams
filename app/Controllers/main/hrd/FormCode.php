<?php

namespace App\Controllers\main\hrd;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\FileModel;

class FormCode extends BaseController
{
    protected $fileModel;
    public function __construct()
    {
        $this->fileModel = new FileModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('150');
        $data = [
            't_title' => lang('app.document code'),
            't_span' => lang('app.span document code'),
            'link' => base_url('formcode'),
            'pHid' => 'hidden',
            'form' => $this->mainModel->getForm($this->urls[1], 'document', '', ''),
        ];

        // var_dump($data['form']);
        // die;
        $this->render('main/hrd/form_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_file', $this->request->getVar('search'), 'u');
            checkPage('150', $db1, 'y', 'n');
            $buttons = setButton($db1);
            if ($db1) $this->logModel->saveLog('Read', $db1[0]->unique, "{$db1[0]->sub_param} ; {$db1[0]->name}");

            $data = [
                't_modal' => lang('app.document code'),
                'link' => base_url('formcode'),
                'pHid' => 'hidden',
                'param' => 'document code',
                'selectGroup' => $this->mainModel->distSelect('numbering', 't'),
                'selectName' => $this->mainModel->distSelect('numbering'),
                'company' => [],
                'form' => $db1,
                'button' => ['save' => $buttons['save'], 'confirm' => $buttons['confirm'], 'delete' => 'disabled', 'active' => $buttons['active']],
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
            $cekData = $this->mainModel->cekData('m_file', 'sub_param', $this->request->getVar('form'), '', '', $this->request->getVar('unique'));
            $ruleForm = ($cekData ? 'valid_email' : 'required');
            $ruleCode = (strlen($this->request->getVar('code')) > "3" ? 'valid_email' : 'required');
            $unique = $this->request->getVar('unique');

            $validationRules = [
                'code' => ['rules' => $ruleCode, 'errors' => ['required' => lang("app.err blank"), 'valid_email' => lang("app.err unique")]],
                'form' => ['rules' => $ruleForm, 'errors' => ['valid_email' => lang("app.err unique")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
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
                        'param' => 'document',
                        'sub_param' => $this->request->getVar('form'),
                        'name' => strtoupper($this->request->getVar('code')),
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

                // Active
                if ($this->request->getVar('postAction') == 'active') {
                    $result = $db1[0]->adaptation[2] == '1' ? ['0', 'inactive', lang("app.title inactive")] : ['1', 'active', lang("app.title active")];
                    $this->fileModel->save(['id' => $db1[0]->id, 'adaptation' => substr($db1[0]->adaptation, 0, 2) . $result[0], 'active_by' => $this->user['id']]);
                    $this->logModel->saveLog('Active', $unique, "{$db1[0]->sub_param} ; {$db1[0]->name} {$result[1]}");
                    $this->session->setFlashdata(['message' => lang('app.' . $db1[0]->sub_param) . " ; {$db1[0]->name} {$result[2]}"]);
                }
                $msg = ['redirect' => '/formcode'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
