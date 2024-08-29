<?php

namespace App\Controllers\file\admin;

use Config\App;
use App\Controllers\BaseController;

class ResetSandi extends BaseController
{
    // ____________________________________________________________________________________________________________________________
    public function index()
    {
        (!preg_match("/106/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_resetsandi"),
            't_submenu' => '',
            't_icon' => '<i class="fa fa-undo ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-user-secret"></i>',
            't_dir1' => lang("app.admin"),
            't_dirac' => lang("app.resetpass"),
            't_link' => '/ulangsandi',
            'user' => $this->deklarModel->getSandiuser(),
            'tuser' => $this->user,
            'tmenu' => $this->menu,
        ];
        return view('file/admin/resetsandi_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function resetdata()
    {
        if ($this->request->isAJAX()) {
            $password = password_hash("A1b2c3d4#", PASSWORD_DEFAULT);
            $usernama = $this->request->getVar('usernama');
            $this->userModel->save([
                'id' => $this->request->getVar('id'),
                'password' => $password,
                'iz_pass' => '0',
            ]);
            $this->logModel->saveLog('Reset', $this->request->getVar('id'), $usernama);
            $msg = ['sukses' => $usernama . ' => ' . lang("app.passreset")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }

    // ____________________________________________________________________________________________________________________________
    public function tabeldata()
    {
        if ($this->request->isAJAX()) {
            $data = ['user' => $this->deklarModel->getSandiuser()];
            $msg = ['data' => view('x-file/resetsandi_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
