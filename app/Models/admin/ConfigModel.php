<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class ConfigModel extends Model
{
    protected $table      = 'm_config';
    protected $allowedFields = ['unique', 'mode', 'param', 'sub_param', 'value', 'save_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getConfig($param = false)
    {
        $query = $this->db->table('m_config');
        $query->select('m_config.*, m_user.code as user');
        $query->join('m_user', 'm_config.save_by = m_user.id', 'left');
        if ($param != false) $query->where('m_config.param', $param);
        return $query->get()->getResultArray();
    }
}
