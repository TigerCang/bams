<?php

namespace App\Controllers\admin;

use Config\App;
use App\Controllers\BaseController;

class LogUser extends BaseController
{
    public function index()
    {
        checkPage('106');
        $data = [
            't_title' => lang('app.user log'),
            't_span' => lang('app.span user log'),
            'link' => base_url('loguser'),
            'blank' => '1',
            'selectUser' => $this->mainModel->distItem('m_user', 'code'),
        ];
        $this->render('admin/loguser_list', $data);
    }
}
