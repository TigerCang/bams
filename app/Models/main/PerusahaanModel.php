<?php

namespace App\Models\main;

use CodeIgniter\Model;

class PerusahaanModel extends Model
{
    protected $table      = 'm_perusahaan';
    protected $allowedFields = ['idunik', 'kode', 'inisial', 'nama', 'hukum1', 'hukum2', 'penerima_id', 'gambar', 'kondisi', 'save_by', 'conf_by', 'aktif_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
