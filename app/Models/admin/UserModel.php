<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'm_user';
    protected $allowedFields = [
        'idunik', 'kode', 'password', 'role_id', 'atasan_id', 'act_setuju', 'act_limit', 'act_button', 'act_akses',
        'perusahaan', 'wilayah', 'divisi', 'jabatan', 'proyek', 'cabang', 'alat', 'tanah', 'kasbank', 'token_id', 'is_reset',
        'dashboard', 'tampilan', 'pintasan', 'set_default', 'gambar', 'gambar_latar', 'kondisi', 'save_by', 'conf_by', 'aktif_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getUser($username)
    {
        return $this->db->table('m_user')
            ->select('m_user.*')
            // ->select('m_user.*, m_penerima.id as idpeg, m_penerima.kode as kodepeg, m_penerima.nip as nippeg, m_penerima.nama as namapeng, m_penerima.is_confirm as confpeg, m_penerima.is_aktif as akpeg')
            // ->join('m_penerima', 'm_user.id = m_penerima.user_id', 'left')
            ->where('m_user.kode', $username)
            // ->where('m_user.is_confirm', '1')
            ->where('substring(m_user.kondisi, 3, 1)', '1')
            ->where('m_user.deleted_at', null)
            ->get()->getRowArray();
    }

    // public function getUser($username)
    // {
    //     return $this->db->table('m_user')
    //         ->select('m_user.*, m_penerima.id as idpeg, m_penerima.kode as kodepeg, m_penerima.nip as nippeg, m_penerima.nama as namapeng, m_penerima.is_confirm as confpeg, m_penerima.is_aktif as akpeg')
    //         ->join('m_penerima', 'm_user.id = m_penerima.user_id', 'left')
    //         ->where('m_user.is_confirm', '1')->where('m_user.is_aktif', '1')->where('m_user.kode', $username)
    //         ->where('m_user.deleted_at', null)
    //         ->get()->getRowArray();
    // }
}
