<?php

namespace App\Models\main;

use CodeIgniter\Model;

class Budget2Model extends Model
{
    protected $table      = 'm_budget2';
    protected $allowedFields = [
        'unique',
        'parent_id',
        'cost_id',
        'account_id',
        'month',
        'quantity',
        'price',
        'total',
        'level',
        'notes',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
