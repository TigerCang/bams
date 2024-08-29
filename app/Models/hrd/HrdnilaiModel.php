<?php

namespace App\Models\hrd;

use CodeIgniter\Model;

class HrdnilaiModel extends Model
{
    protected $table      = 'hrd_nilai';
    protected $allowedFields = ['idunik', 'perusahaan_id', 'wilayah_id', 'divisi_id', 'userid', 'pegawai_id', 'nodoc', 'tgl_nilai', 'nilai', 'catatan'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
