<?php

namespace App\Models\tritem;

use CodeIgniter\Model;

class POanakModel extends Model
{
    protected $table      = 'po_anak';
    protected $allowedFields = ['pominta_id', 'jenis', 'item_id', 'spesifikasi', 'jumlah', 'ada', 'satuan', 'konversi', 'level_pos', 'is_ada', 'status', 'catatan'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
