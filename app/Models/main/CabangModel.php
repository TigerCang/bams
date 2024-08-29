<?php

namespace App\Models\main;

use CodeIgniter\Model;

class CabangModel extends Model
{
    protected $table      = 'm_cabang';
    protected $allowedFields = [
        'idunik', 'kode', 'nama', 'alamat', 'perusahaan_id', 'wilayah_id', 'divisi_id', 'catatan', 'is_jual', 'kondisi',
        'save_by', 'conf_by', 'aktif_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
