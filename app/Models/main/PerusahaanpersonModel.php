<?php

namespace App\Models\main;

use CodeIgniter\Model;

class PerusahaanpersonModel extends Model
{
    protected $table      = 'perusahaan_person';
    protected $allowedFields = ['perusahaan_id', 'judul', 'pilih', 'nomor', 'nama', 'identitas', 'jabatan', 'alamat', 'jumlah', 'harga', 'total', 'is_use'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
