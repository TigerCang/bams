<?php

namespace App\Models\main;

use CodeIgniter\Model;

class KBLIModel extends Model
{
    protected $table      = 'm_kbli';
    protected $allowedFields = ['idunik', 'param', 'kode', 'nama', 'pajak_id', 'kondisi', 'save_by', 'conf_by', 'aktif_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
