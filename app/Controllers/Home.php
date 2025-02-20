<?php

namespace App\Controllers;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\PersonModel;

class Home extends BaseController
{
    protected $personModel;
    public function __construct()
    {
        $this->personModel = new PersonModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        $data = [];

        $this->render('home/home_view', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function profile()
    {
        $db = $this->personModel->getPerson(decrypt(session()->username));
        (empty($db)) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data = [
            'person' => $db,
            'company' => $this->mainModel->getData('m_company', $db[0]->company_id, '', 'id'),
        ];
        $this->render('home/profile_view', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function layouts()
    {
        $db = $this->personModel->getPerson(decrypt(session()->username));
        (empty($db)) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data = [
            't_title' => lang('app.layouts'),
            't_span' => lang('app.span layouts'),
            'company' => $this->mainModel->getCompany('', 't'),
            'region' => $this->mainModel->getFile('', 'region', 't'),
            'division' => $this->mainModel->getFile('', 'division', 't'),
            'selectObject' => $this->mainModel->distSelect('object'),
            'user' => $db,
            'link' => base_url('layouts'),
        ];
        $this->render('home/layouts_input', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveLayouts()
    {
        if ($this->request->isAJAX()) {
            $db = $this->userModel->getUser(decrypt(session()->username));
            $defaultHeader = implode(',', [$this->request->getVar('company'), $this->request->getVar('region'), $this->request->getVar('division'), $this->request->getVar('object')]);
            $this->userModel->save([
                'id' =>  $db['id'],
                'set_default' =>  $defaultHeader,
            ]);
            $msg = ['message' => lang('app.layouts') . ' ' . decrypt(session()->username) . lang('app.title save')];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function changePassword()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_user', $this->request->getVar('usernameOC'), '', 'code');
            $oldPassword = password_verify($this->request->getVar('oldPasswordOC'), $db1['0']->password);
            $ruleOldPassword = (!$oldPassword) ? 'valid_email' : 'required';
            $ruleNewPassword = ($this->request->getVar('newPasswordOC') != $this->request->getVar('confirmationOC')) ? 'valid_email' : 'required|password_strength[8]';

            $validationRules = [
                'oldPasswordOC' => [
                    'rules' => $ruleOldPassword,
                    'errors' => ['required' => lang("app.err blank"), 'valid_email' => lang("app.err wrong password")]
                ],
                'newPasswordOC' => [
                    'rules' => $ruleNewPassword,
                    'errors' => ['required' => lang("app.err blank"), 'password_strength' => lang("app.err password strong"), 'valid_email' => lang("app.err wrong password")]
                ],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'oldPasswordOC' => $this->validation->getError('oldPasswordOC'),
                        'newPasswordOC' => $this->validation->getError('newPasswordOC'),
                    ]
                ];
            } else {
                $password = password_hash($this->request->getVar('newPasswordOC'), PASSWORD_DEFAULT);
                $this->userModel->save(['id' => $db1['0']->id, 'password' => $password]);
                $this->logModel->saveLog('Save', '', $this->request->getVar('usernameOC'), '', 'a', 'Change Password');
                $msg = ['success' => lang('app.password success')];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function logData()
    {
        $data = [
            't_title' => lang("app.activity log"),
            't_span' => lang('app.span user log'),
            'link' => base_url('loguser'),
            'blank' => '0',
            'selectUser' => $this->mainModel->getData('m_user', decrypt(session()->username), '', 'code'),
        ];
        $this->render('admin/loguser_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function bahasa()
    {
        $session = session();
        $locale = $this->request->getLocale();
        $session->remove('lang');
        $session->set('lang', $locale);
        $backUrl = $this->request->getServer('HTTP_REFERER'); // Ambil URL sebelumnya
        return redirect()->to($backUrl);
    }
}
