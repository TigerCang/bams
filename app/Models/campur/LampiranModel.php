<?php

namespace App\Models\campur;

use CodeIgniter\Model;

class LampiranModel extends Model
{
    protected $table      = 'm_lampiran';
    protected $allowedFields = ['idunik', 'param', 'judul', 'deskripsi', 'tanggal', 'lampiran', 'save_by'];
    protected $useTimestamps = true;

    public function getLampiran($param, $data, $field = 'idunik')
    {
        $query = $this->db->table('m_lampiran');
        $query->select('m_lampiran.*, m_user.kode as user');
        if ($field == 'idunik')
            $query->where('m_lampiran.param', $param)->where('m_lampiran.idunik', $data);
        else
            $query->where('m_lampiran.id', $data);
        $query->join('m_user', 'm_lampiran.save_by = m_user.id', 'left');
        $query->orderby('m_lampiran.judul');
        return $query->get()->getResultArray();
    }
}
