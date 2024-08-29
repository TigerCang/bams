<?php

namespace App\Models\main;

use CodeIgniter\Model;

class BerkasModel extends Model
{
    protected $table      = 'm_berkas';
    protected $allowedFields = [
        'idunik', 'param', 'sub_param', 'nama', 'nama2', 'perusahaan_id', 'wilayah_id', 'divisi_id', 'nilai', 'set_default',
        'kondisi', 'save_by', 'conf_by', 'aktif_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
