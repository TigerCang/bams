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
        return view('login/signin_input');
    }

    public function auth()
    {
        $db = $this->userModel->getUser($this->request->getVar('usernama'));
        if ($db && password_verify($this->request->getVar('sandi'), $db['password'])) {
            $session_data = [
                'usernama' => $this->request->getVar('usernama'),
                'avatar' => $db['gambar'],
                'log_in' => TRUE
            ];
            $this->session->set($session_data);
            $this->logModel->saveLog('Login', '');
            return redirect()->to('/');
        }
        $this->session->setFlashdata('pesan', lang("app.salah login"));
        return redirect()->to('/login');
    }

    public function logout()
    {
        if (!is_null(session()->usernama)) {
            $this->logModel->saveLog('Logout', '', session()->usernama);
            session()->destroy();
        }
        return redirect()->to('/login');
    }

    // _________________________________________________________________________________________________________________________
    public function viewSandi()
    {
        return view('login/reset_input');
    }
    // public function resetsandi()
    // {
    //     $db = $this->userModel->getUser($this->request->getVar('usernama'));
    //     if ($db) {
    //         $db1 = $this->deklarModel->cekUserpegawai($db['id']);
    //         if ($db1) {
    //             if ($db1['0']->kode == $this->request->getVar('kode')) {
    //                 $this->userModel->save(['id' => $db['id'], 'iz_pass' => '1']);
    //                 $this->session->setflashdata('pesanlogin', lang("app.mintaresetsukses"));
    //                 return redirect()->to('/recover');
    //             }
    //         }
    //     }
    //     $this->session->setflashdata('pesanlogin', lang("app.datatakcocok"));
    //     return redirect()->to('/recover');
    // }

    // _________________________________________________________________________________________________________________________
    public function viewSignup()
    {
        return view('login/signup_input');
    }
    public function signup()
    {
        $dbtoken = $this->mainModel->cekToken(strtoupper($this->request->getVar('token')));
        $usernama = $this->request->getVar('usernama');

        if (strlen($usernama) <= 3 || $this->mainModel->satuID('m_user', $usernama, 'kode') || empty($dbtoken)) {
            $this->session->setFlashdata('pesan', lang("app.salah signup"));
            return redirect()->to('/signup');
        }
        $this->userModel->save([
            'idunik' => buatid(),
            'kode' => $usernama,
            'password' => password_hash("A1b2c3d4#", PASSWORD_DEFAULT),
            'token_id' => $dbtoken[0]->id,
            'kondisi' => '101',
        ]);
        $this->mainModel->updateData('user_token', 'is_use', '1', 'token', strtoupper($this->request->getVar('token')));
        $this->session->setflashdata('pesan sukses', lang("app.buat user"));
        return redirect()->to('/signup');
    }
}
