<?php

namespace App\Models\main;

use CodeIgniter\Model;

class AkunModel extends Model
{
    protected $table      = 'm_akun';
    protected $allowedFields = ['idunik', 'kode', 'nama', 'level', 'kategori', 'induk_id', 'posisi', 'kondisi', 'save_by', 'conf_by', 'aktif_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
