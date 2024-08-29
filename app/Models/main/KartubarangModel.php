<?php

namespace App\Models\file;

use CodeIgniter\Model;

class KartubarangModel extends Model
{
    protected $table      = 'kartu_barang';
    protected $allowedFields = [
        'nodoc', 'masuk_id', 'keluar_id', 'barang_id', 'gudang_id', 'tanggal', 'jl_masuk', 'jl_keluar', 'jl_sisa', 'harga', 'catatan', 'penerima_id',
        'pilihan', 'beban_id', 'biaya_id',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
