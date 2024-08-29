<?php

namespace App\Controllers\file\admin;

use Config\App;
use App\Controllers\BaseController;

class LogUser extends BaseController
{
    public function index()
    {
        (!preg_match("/105/i", $this->menu['menu_1'])) && throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        $data = [
            't_menu' => lang("app.tt_loguser"),
            't_submenu' => '',
            't_icon' => '<i class="icofont icofont-list ' . lang("app.xlist") . '"></i>',
            't_diricon' => '<i class="fa fa-user-secret"></i>',
            't_dir1' => lang("app.admin"),
            't_dirac' => lang("app.loguser"),
            't_link' => '/loguser',
            'user' => $this->deklarModel->getUser('', '', 't'),
            'uhid' => '',
            'tuser' => $this->user,
            'tmenu' => $this->menu,
        ];
        return view('file/admin/loguser_view', $data);
    }

    // ____________________________________________________________________________________________________________________________
    public function tabellog()
    {
        if ($this->request->isAJAX()) {
            $usernama = ($this->request->getVar('hid') == 'hidden') ? $this->session->usernama : $this->request->getVar('usernama');
            $detil = ''; //$this->request->getVar('detil')
            $data = [
                'isilog' => $this->deklarModel->getLog($usernama, $this->request->getVar('isi'), $detil),
                'uhid' => $this->request->getVar('hid'),
            ];
            $msg = ['data' => view('x-file/loguser_tabel', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}
