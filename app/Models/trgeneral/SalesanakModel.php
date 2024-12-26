<?php

namespace App\Models\umum;

use CodeIgniter\Model;

class SalesanakModel extends Model
{
    protected $table      = 'sales_anak';
    protected $allowedFields = [
        'soinduk_id', 'poinduk_id', 'namajasa', 'data_id', 'noseri_id', 'bentuk', 'kategori_id', 'jumlah', 'satuan', 'harga', 'diskon',
        'total', 'catatan'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
