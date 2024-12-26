<?php

namespace App\Models\main;

use CodeIgniter\Model;

class CostModel extends Model
{
    protected $table      = 'm_cost';
    protected $allowedFields = [
        'unique',
        'param',
        'parent_id',
        'category_id',
        'code',
        'pay_code',
        'name',
        'unit',
        'level',
        'account_id',
        'is_total',
        'adaptation',
        'save_by',
        'confirm_by',
        'active_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
