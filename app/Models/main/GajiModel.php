<?php

namespace App\Models\file;

use CodeIgniter\Model;

class GajiModel extends Model
{
    protected $table      = 'm_gajipeg';
    protected $allowedFields = ['id_unik', 'kode', 'nama', 'nilai'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
