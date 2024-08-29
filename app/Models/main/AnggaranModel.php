<?php

namespace App\Models\main;

use CodeIgniter\Model;

class AnggaranModel extends Model
{
    protected $table      = 'm_anggaran';
    protected $allowedFields = [
        'idunik', 'judul', 'param', 'jenis', 'biaya_id', 'akun_id', 'bulan', 'jumlah', 'harga', 'total', 'catatan', 'levsatu',
        'kondisi', 'save_by', 'conf_by', 'aktif_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
