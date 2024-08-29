<?php

namespace App\Models\kas;

use CodeIgniter\Model;

class KasindukModel extends Model
{
    protected $table      = 'kas_induk';
    protected $allowedFields = [
        'idunik', 'param', 'beban', 'nodokumen', 'tgl_minta', 'tgl_beban', 'beban_id', 'penerima_id', 'kbli_id', 'revisi', 'jenis', 
        'level', 'setuju', 'periode', 'is_masuk', 'is_pajak', 'status', 'lampiran', 'perusahaan_id', 'wilayah_id', 'divisi_id', 
        'usernama', 'peminta', 'last_id'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
