<?php

namespace App\Models\file;

use CodeIgniter\Model;

class AtkModel extends Model
{
    protected $table      = 'm_atk';
    protected $allowedFields = ['idunik', 'nama', 'satuan', 'updated_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
