<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table      = 'user_log';
    protected $allowedFields = ['idunik', 'usernama', 'menu', 'aksi',  'data', 'catatan', 'alamat', 'ip_address', 'user_agent', 'last_act'];
    protected $useTimestamps = true;
    protected $urls;

    public function __construct()
    {
        parent::__construct();
        $this->urls = explode('/', $_SERVER['REQUEST_URI']);
    }

    public function saveLog($aksi, $idunik, $data = '', $catatan = '')
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();

        $this->save([
            'idunik' => $idunik,
            'usernama' => $session->get()['usernama'] ?? '',
            'menu' => $this->urls[1],
            'aksi' => $aksi,
            'data' => $data,
            'catatan' => $catatan,
            'alamat' => $session->get()['_ci_previous_url'] ?? '',
            'ip_address' => getIP(),
            'user_agent' => $request->getUserAgent()->getBrowser() . ' ' . $request->getUserAgent()->getVersion() .
                ', ' . $request->getUserAgent()->getPlatform() . ', ' . $request->getUserAgent()->getMobile(),
            'last_act' => $session->get()['__ci_last_regenerate'] ?? '',
        ]);
    }
}
