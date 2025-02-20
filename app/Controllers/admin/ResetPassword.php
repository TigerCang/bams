<?php

namespace App\Controllers\admin;

use Config\App;
use App\Controllers\BaseController;

class ResetPassword extends BaseController
{
    public function index()
    {
        checkPage('107');
        $data = [
            't_title' => lang('app.reset password'),
            't_span' => lang('app.span reset password'),
            'user' => $this->mainModel->getUserReset(),
        ];
        $this->render('admin/resetPassword_list', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function resetData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_user', $this->request->getVar('unique'));
            $password = password_hash("A1b2c3d4#", PASSWORD_DEFAULT);
            $this->userModel->save([
                'id' => $db1[0]->id,
                'password' => $password,
                'is_reset' => '0',
            ]);
            $this->logModel->saveLog('Reset', $this->request->getVar('unique'), $db1[0]->code);
            $this->session->setFlashdata(['message' => $db1[0]->code . ' => ' . lang("app.password reset")]);
            $msg = ['redirect' => '/resetpassword'];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function searchData()
    {
        if ($this->request->isAJAX()) {
            $data = ['user' => $this->mainModel->getUserReset()];
            $msg = ['data' => view('x-main/userReset_table', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
