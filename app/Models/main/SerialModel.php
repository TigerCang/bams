<?php

namespace App\Models\main;

use CodeIgniter\Model;

class SerialModel extends Model
{
    protected $table      = 'm_serial';
    protected $allowedFields = ['idunik', 'barang_id', 'noseri', 'harga', 'alat_id', 'reparasi', 'kondisi', 'save_by', 'conf_by', 'aktif_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
