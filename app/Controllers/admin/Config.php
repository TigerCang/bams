<?php

namespace App\Controllers\admin;

use Config\App;
use App\Controllers\BaseController;

class Config extends BaseController
{
    public function index()
    {
        checkPage('102');
        $data = [
            't_title' => lang('app.config'),
            't_span' => lang('app.span config'),
            'link' => base_url('config'),
            'config' => $this->configModel->getConfig(),
        ];
        $this->render('admin/config_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->configModel->getConfig($this->request->getVar('search'));
            checkPage('102', $db1, 'y', 'n');
            if ($db1) $this->logModel->saveLog('Read', $db1[0]['unique'], $db1[0]['param']);

            $data = [
                'link' => base_url('config'),
                't_modal' => lang('app.config'),
                'config' => $db1,
            ];
            $msg = ['data' => view('admin/config_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->configModel->getConfig($this->request->getVar('xParam'));
            $ruleLevel = ($db1[0]['mode'] == "A" ? 'required' : 'permit_empty');
            $ruleDescription = ($db1[0]['mode'] == "B" ? 'required' : 'permit_empty');
            $value = ($db1[0]['mode'] == "A" ? $this->request->getVar('level') : $this->request->getVar('description'));

            $validationRules = [
                'level' => ['rules' => $ruleLevel, 'errors' => ['required' => lang("app.err blank")]],
                'description' => ['rules' => $ruleDescription, 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'level' => $this->validation->getError('level'),
                        'description' => $this->validation->getError('description'),
                    ]
                ];
            } else {
                $path = FCPATH . 'assets/' . $db1[0]['sub_param'] . '/' . $this->request->getVar('description'); // Path absolute on system file
                if (!is_dir($path)) mkdir($path, 0777, true);
                $this->configModel->save(['id' => $db1[0]['id'], 'value' => $value, 'save_by' => $this->user['id']]);
                $this->logModel->saveLog('Save', $db1[0]['param']);
                $this->session->setFlashdata(['message' => lang('app.' . $db1[0]['param']) . lang('app.title edit')]);
                $msg = ['redirect' => '/config'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
