<?php

namespace App\Models\tritem;

use CodeIgniter\Model;

class POambilModel extends Model
{
    protected $table      = 'po_ambil';
    protected $allowedFields = ['idunik', 'user_id', 'penerima_id', 'nodoc', 'tanggal', 'perusahaan_id', 'wilayah_id', 'divisi_id',  'atk_id', 'jumlah', 'catatan', 'status'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
