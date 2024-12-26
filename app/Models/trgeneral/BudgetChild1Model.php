<?php

namespace App\Models\trgeneral;

use CodeIgniter\Model;

class BudgetChild1Model extends Model
{
    protected $table      = 'budget_child1';
    protected $allowedFields = [
        'unique',
        'parent_id',
        'cost_id',
        'account_id',
        'month',
        'quantity',
        'price_contract',
        'price_work',
        'total_contract',
        'total_work',
        'group_industry',
        'notes',
        'level_one'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
