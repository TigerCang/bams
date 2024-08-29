<?php

namespace App\Controllers\admin;

use Config\App;
use App\Controllers\BaseController;
use App\Models\admin\TokenModel;

class Token extends BaseController
{
    protected $tokenModel;
    public function __construct()
    {
        $this->tokenModel = new TokenModel();
    }

    public function index()
    {
        checkPage('102');
        $data = [
            't_judul' => lang('app.token'),
            't_span' => lang('app.span token'),
            'link' => '/token',
            'token' => $this->mainModel->getToken($this->urls[1]),
        ];
        $this->render('admin/token_list', $data);
    }

    // _________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $data = [
                't_modal' => lang('app.token'),
                'link' => "/token",
                'tuser' => $this->user,
            ];
            $msg = ['data' => view('admin/token_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // _________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $validationRules = [
                'peminta' => ['rules' => 'required|is_unique[user_token.peminta]', 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unik")]],
            ];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['peminta' => $this->validation->getError('peminta')]];
            } else {
                $token = buatToken();
                $this->tokenModel->save([
                    'peminta' => $this->request->getVar('peminta'),
                    'token' => $token,
                    'save_by' => $this->user['id'],
                ]);
                $this->logModel->saveLog('Save', $token, $this->request->getVar('peminta'));
                $this->session->setFlashdata(['pesan' => $this->request->getVar('peminta') . lang('app.judul buat')]);
                $msg = ['redirect' => '/token'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
