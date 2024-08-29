<?php

namespace App\Models\trumum;

use CodeIgniter\Model;

class AnggaranindukModel extends Model
{
    protected $table      = 'anggaran_induk';
    protected $allowedFields = [
        'idunik', 'user_id', 'last_id', 'pilihan', 'tujuan', 'jenis', 'perusahaan_id', 'wilayah_id', 'divisi_id', 'beban_id', 'ruas_id', 'nodoc',
        'tanggal1', 'tanggal2', 'adendum', 'revisi', 'level_aw', 'level_pos', 'status', 'is_use', 'catatan'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
