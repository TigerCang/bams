<?php

namespace App\Models\main;

use CodeIgniter\Model;

class Budget1Model extends Model
{
    protected $table      = 'm_budget1';
    protected $allowedFields = [
        'unique',
        'title',
        'source',
        'object',
        'type',
        'total',
        'adaptation',
        'save_by',
        'confirm_by',
        'active_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
