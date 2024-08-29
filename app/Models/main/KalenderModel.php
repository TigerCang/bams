<?php

namespace App\Models\main;

use CodeIgniter\Model;

class KalenderModel extends Model
{
    protected $table      = 'm_kalender';
    protected $allowedFields = ['tanggal', 'nama', 'cut_cuti', 'save_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
