<?php

namespace App\Controllers;

use Config\App;
use App\Controllers\BaseController;
use App\Models\admin\UserModel;

class Home extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        $data = [
            //     't_menu' => lang("app.dasbor"), 't_submenu' => '',
            //     't_icon' => '<i class="feather icon-home ' . lang("app.xlist") . '"></i>',
            //     't_diricon' => '<i class="icofont icofont-ui-home"></i>', 't_dir1' => lang("app.home"), 't_dirac' => lang("app.dasbor"), 't_link' => '/',
            // 'this_user' => $this->user,
            // 'this_menu' => $this->menu,
            'template' => (splitUser('template', $this->user)[0]),
        ];
        return view('dashboard/home', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function profilpegawai()
    {
        $data = [
            't_menu' => lang("app.tt_userprofil"),
            't_submenu' => '',
            't_icon' => '<i class="icofont icofont-business-man ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-home"></i>',
            't_dir1' => lang("app.home"),
            't_dirac' => lang("app.profil"),
            't_link' => '/profile',
            'biodata' => $this->deklarModel->getBiodata($this->user['id']),
            'tuser' => $this->user,
            'tmenu' => $this->menu,
        ];
        (empty($data['biodata'])) && throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('home/biodata_view', $data);
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
                // $this->userModel->save(['id' => $db1['0']->id, 'password' => $password]);
                // $this->logModel->saveLog('Save', '', $this->request->getVar('usernameOC'));
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
            'link' => '/loguser',
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
