<?php

namespace App\Models\kas;

use CodeIgniter\Model;

class KasdetilModel extends Model
{
    protected $table      = 'kas_detil';
    protected $allowedFields = ['kasinduk_id', 'kasanak_id', 'biaya_id', 'akun_id', 'debit', 'kredit', 'sisa', 'catatan'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
