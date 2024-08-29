<?php

namespace App\Models\trumum;

use CodeIgniter\Model;

class AnggarananakModel extends Model
{
    protected $table      = 'anggaran_anak';
    protected $allowedFields = [
        'anggaraninduk_id', 'biaya_id', 'akun_id', 'bulan', 'jumlah_kontrak', 'jumlah_cco', 'harga_kontrak', 'harga_kerja', 'total_kontrak', 'total_kerja',
        'harga_kontrak_cco', 'harga_kerja_cco', 'total_kontrak_cco', 'total_kerja_cco', 'kelin', 'catatan', 'levsatu'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
