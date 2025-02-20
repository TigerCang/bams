<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table      = 'user_log';
    protected $allowedFields = ['unique', 'username', 'menu', 'action', 'data', 'notes', 'web_address', 'ip_address', 'user_agent', 'last_act'];
    protected $useTimestamps = true;
    protected $urls;

    public function __construct()
    {
        parent::__construct();
        $this->urls = explode('/', $_SERVER['REQUEST_URI']);
    }

    public function saveLog($action, $unique = '', $data = '', $notes = '', $source = 'a', $menu = '')
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();

        $this->save([
            'unique' => $unique,
            'username' => decrypt($session->get()['username'] ?? ''),
            'menu' => ($menu == '' ? $this->urls[1] : $menu),
            'action' => $action,
            'data' => $data,
            'notes' => $notes,
            'source' => $source,
            'web_address' => ($menu == '' ? $session->get()['_ci_previous_url'] : $menu),
            'ip_address' => getIP(),
            'user_agent' => $request->getUserAgent()->getBrowser() . ' ' . $request->getUserAgent()->getVersion() .
                ', ' . $request->getUserAgent()->getPlatform() . ', ' . $request->getUserAgent()->getMobile(),
            'last_act' => $session->get()['__ci_last_regenerate'] ?? '',
        ]);
    }
}
