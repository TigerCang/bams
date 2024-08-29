<?php

namespace App\Models\main;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table      = 'm_barang';
    protected $allowedFields = [
        'idunik', 'param', 'kode', 'partnumber', 'sumberdaya_id', 'nama', 'kategori', 'merk', 'satuan', 'kakun_id', 'stokmin', 'harga',
        'sebes', 'gambar', 'catatan', 'kondisi', 'save_by', 'conf_by', 'aktif_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
