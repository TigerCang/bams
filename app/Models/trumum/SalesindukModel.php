<?php

namespace App\Models\umum;

use CodeIgniter\Model;

class SalesindukModel extends Model
{
    protected $table      = 'sales_induk';
    protected $allowedFields = [
        'idunik', 'perusahaan_id', 'wilayah_id', 'divisi_id', 'userid', 'modeorder', 'camp_id', 'nodoc', 'tanggal', 'nopo', 'penerima_id',
        'proyek_id', 'pilihdata', 'is_pajak', 'level_aw', 'level_pos', 'level_acc', 'st_cek', 'st_setuju', 'st_jual', 'st_tutup'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
