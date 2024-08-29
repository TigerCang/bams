<?php

namespace App\Models\main;

use CodeIgniter\Model;

class BiayaModel extends Model
{
    protected $table      = 'm_biaya';
    protected $allowedFields = [
        'idunik', 'param', 'induk_id', 'kate_id', 'kode', 'matabayar', 'nama', 'satuan', 'level', 'akun_id', 'is_jumlah', 'kondisi',
        'save_by', 'conf_by', 'aktif_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
