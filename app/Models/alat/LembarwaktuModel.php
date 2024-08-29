<?php

namespace App\Models\alat;

use CodeIgniter\Model;

class LembarwaktuModel extends Model
{
    protected $table      = 'lembar_ts';
    protected $allowedFields = [
        'sosewa_id', 'notiket', 'subruas_id', 'biaya_id', 'gudang_id', 'alat_id', 'alatperush_id', 'alatdiv_id', 'supir_id', 'supirperush_id',
        'supirwil_id', 'supirdiv_id', 'bahan_id', 'tanggal', 'jumlah', 'utambah', 'catatan', 'st_tiket'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
