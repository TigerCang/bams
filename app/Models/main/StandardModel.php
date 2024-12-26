<?php

namespace App\Models\main;

use CodeIgniter\Model;

class StandardModel extends Model
{
    protected $table      = 'm_standard';
    protected $allowedFields = ['unique', 'param', 'code', 'name', 'tax_id', 'adaptation', 'save_by', 'confirm_by', 'active_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
