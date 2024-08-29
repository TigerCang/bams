<?php

namespace App\Models\main;

use CodeIgniter\Model;

class PerusahaandataModel extends Model
{
    protected $table      = 'perusahaan_data';
    protected $allowedFields = ['perusahaan_id', 'pusat', 'alamat', 'kota', 'telepon', 'faximili', 'email', 'nopajak'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
