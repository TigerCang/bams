<?php

namespace App\Models\main;

use CodeIgniter\Model;

class RuasModel extends Model
{
    protected $table      = 'm_ruas';
    protected $allowedFields = ['idunik', 'param', 'proyek_id', 'ruas_id', 'cabang_id', 'kode', 'nama', 'jarak', 'catatan', 'kondisi', 'save_by', 'conf_by', 'aktif_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
