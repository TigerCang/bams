<?php

namespace App\Models\trkas;

use CodeIgniter\Model;

class KaspajakModel extends Model
{
    protected $table      = 'kas_pajak';
    protected $allowedFields = ['kasanak_id', 'nomor', 'masapajak', 'objekpajak_id', 'ni_dpp', 'tarif', 'ni_potong', 'dokumenref_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
