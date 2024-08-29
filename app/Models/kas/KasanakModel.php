<?php

namespace App\Models\kas;

use CodeIgniter\Model;

class KasanakModel extends Model
{
    protected $table      = 'kas_anak';
    protected $allowedFields = [
        'kasinduk_id', 'kasdetil_id', 'ruas_id', 'anggaran_id', 'biaya_id', 'akun_id', 'sumberdaya_id', 'osm_id', 'item_id', 'jumlah', 'harga', 'debit',
        'kredit', 'catatan', 'anak_id', 'mode', 'asal', 'in_pph'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
