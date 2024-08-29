<?php

namespace App\Models\tritem;

use CodeIgniter\Model;

class POmintaModel extends Model
{
    protected $table      = 'po_minta';
    protected $allowedFields = [
        'idunik', 'user_id', 'peminta_id', 'last_id', 'perusahaan_id', 'wilayah_id', 'divisi_id',  'nodoc', 'tanggal', 'revisi', 'level_aw', 'level_pos',
        'is_sama', 'st_seru', 'status'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
