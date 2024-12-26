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
        checkPage('105');
        $data = [
            't_title' => lang('app.token'),
            't_span' => lang('app.span token'),
            'link' => '/token',
            'token' => $this->mainModel->getToken($this->urls[1]),
        ];
        $this->render('admin/token_list', $data);
    }


    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            $data = [
                't_modal' => lang('app.token'),
                'link' => "/token",
            ];
            $msg = ['data' => view('admin/token_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $validationRules = ['person' => ['rules' => 'required|is_unique[user_token.person]', 'errors' => ['required' => lang("app.err blank"), 'is_unique' => lang("app.err unique")]]];
            if (!$this->validate($validationRules)) {
                $msg = ['error' => ['person' => $this->validation->getError('person')]];
            } else {
                $token = createToken();
                $this->tokenModel->save([
                    'person' => $this->request->getVar('person'),
                    'token' => $token,
                    'save_by' => $this->user['id'],
                ]);
                $this->logModel->saveLog('Save', $token, $this->request->getVar('person'));
                $this->session->setFlashdata(['message' => $this->request->getVar('person') . lang('app.title create')]);
                $msg = ['redirect' => '/token'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}
