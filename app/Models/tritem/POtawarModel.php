<?php

namespace App\Models\tritem;

use CodeIgniter\Model;

class POtawarModel extends Model
{
    protected $table      = 'po_tawar';
    protected $allowedFields = ['pominta_id', 'poorder_id', 'poanak_id', 'penerima_id', 'jumlah', 'harga', 'diskon', 'total', 'st_pajak', 'st_pilih', 'catatan'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
