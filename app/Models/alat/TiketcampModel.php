<?php

namespace App\Models\alat;

use CodeIgniter\Model;

class TiketcampModel extends Model
{
    protected $table      = 'tiket_camp';
    protected $allowedFields = [
        'sojual_id', 'sojual2_id', 'sosewa_id', 'sosewa2_id', 'asal', 'notiket', 'subruas_id', 'biaya_id', 'gudang_id', 'barang_id', 'alat_id',
        'alatperush_id', 'alatdiv_id', 'supir_id', 'supirperush_id', 'supirwil_id', 'supirdiv_id', 'tanggal', 'jumlah', 'catatan', 'st_tiket'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
