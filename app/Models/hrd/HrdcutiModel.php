<?php

namespace App\Models\hrd;

use CodeIgniter\Model;

class HrdcutiModel extends Model
{
    protected $table      = 'hrd_cuti';
    protected $allowedFields = [
        'idunik', 'perusahaan_id', 'wilayah_id', 'divisi_id', 'userid', 'pegawai_id', 'nodoc', 'cuti_id', 'tgl_minta', 'tgl_cuti1', 'tgl_cuti2', 'lama',
        'potong', 'status', 'catatan', 'st_atasan', 'st_hrd', 'st_bos', 'lampiran'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
