<?php

namespace App\Models\main;

use CodeIgniter\Model;

class KelakunModel extends Model
{
    protected $table      = 'm_kelakun';
    protected $allowedFields = [
        'idunik', 'asal', 'param', 'sub_param', 'nama', 'nilai', 'perusahaan_id', 'wilayah_id', 'divisi_id', 'akun1_id', 'akun2_id',
        'akun3_id', 'akun4_id', 'akun5_id', 'catatan', 'set_default', 'kondisi', 'save_by', 'conf_by', 'aktif_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
