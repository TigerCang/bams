<?php

namespace App\Controllers;

use Config\App;
use App\Controllers\BaseController;
use App\Models\admin\TokenModel;

class Login extends BaseController
{
    protected $tokenModel;
    public function __construct()
    {
        $this->tokenModel = new TokenModel();
    }

    public function index()
    {
        return view('login/login_input');
    }

    public function auth()
    {
        $db1 = $this->userModel->getUser($this->request->getVar('username'));
        if ($db1 && password_verify($this->request->getVar('password'), $db1['password'])) {
            $session_data = [
                'username' => encrypt($this->request->getVar('username')),
                'avatar' => $db1['picture'],
                'log_in' => TRUE
            ];
            $this->session->set($session_data);
            $this->logModel->saveLog('Login');
            return redirect()->to('/');
        }
        $this->session->setFlashdata('message', lang("app.wrong user"));
        return redirect()->to('/login');
    }

    public function logout()
    {
        if (!is_null(session()->username)) {
            $this->logModel->saveLog('Logout');
            session()->destroy();
        }
        return redirect()->to('/login');
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function viewPassword()
    {
        return view('login/password_input');
    }

    public function resetPassword()
    {
        $db = $this->userModel->getUser($this->request->getVar('username'));
        if ($db) {
            $db1 = $this->mainModel->getData('m_person', $db['id'], '', 'user_id', 't');
            if ($db1) {
                if ($db1['0']->code == $this->request->getVar('code')) {
                    $this->userModel->save(['id' => $db['id'], 'is_reset' => '1']);
                    $this->session->setflashdata('success message', lang("app.reset success"));
                    return redirect()->to('/forget');
                }
            }
        }
        $this->session->setflashdata('message', lang("app.not match"));
        return redirect()->to('/forget');
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function viewSignup()
    {
        return view('login/signup_input');
    }

    public function processSignup()
    {
        $db_token = $this->mainModel->cekToken(strtoupper($this->request->getVar('token')));
        $username = $this->request->getVar('username');

        if (strlen($username) <= 3 || $this->mainModel->getData('m_user', $username, 'code') || empty($db_token)) {
            $this->session->setFlashdata('message', lang("app.wrong signup"));
            return redirect()->to('/signup');
        }
        $this->userModel->save([
            'unique' => create_Unique(),
            'code' => $username,
            'password' => password_hash("A1b2c3d4#", PASSWORD_DEFAULT),
            'token_id' => $db_token[0]->id,
            'adaptation' => '101',
        ]);
        $this->mainModel->updateData('user_token', 'is_use', '1', 'token', strtoupper($this->request->getVar('token')));
        $this->session->setflashdata('success message', lang("app.make user"));
        return redirect()->to('/signup');
    }
}
