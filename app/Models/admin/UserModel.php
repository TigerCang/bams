<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'm_user';
    protected $allowedFields = [
        'unique',
        'code',
        'password',
        'role_id',
        'supervisor_id',
        'act_approve',
        'act_limit',
        'act_button',
        'act_access',
        'company',
        'region',
        'division',
        'salary',
        'project',
        'branch',
        'tool',
        'land',
        'cash',
        'token_id',
        'is_reset',
        'dashboard',
        'template',
        'shortcut',
        'set_default',
        'picture',
        'picture_line',
        'adaptation',
        'save_by',
        'confirm_by',
        'active_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getUser($username)
    {
        return $this->db->table('m_user')
            ->select('m_user.*')
            ->where('m_user.code', $username)->where('substring(m_user.adaptation, 2, 1)', '1')->where('substring(m_user.adaptation, 3, 1)', '1')
            ->where('m_user.deleted_at', null)
            ->get()->getRowArray();
    }
}
