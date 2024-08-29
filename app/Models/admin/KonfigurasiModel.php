<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class KonfigurasiModel extends Model
{
    protected $table      = 'm_konfigurasi';
    protected $allowedFields = ['idunik', 'mode', 'param', 'sub_param', 'nilai', 'save_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getKonfigurasi($param = false)
    {
        $query = $this->db->table('m_konfigurasi');
        $query->select('m_konfigurasi.*, m_user.kode as user');
        $query->join('m_user', 'm_konfigurasi.save_by = m_user.id', 'left');
        if ($param !== false) $query->where('m_konfigurasi.param', $param);
        return $query->get()->getResultArray();
    }
}
