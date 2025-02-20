<?php

namespace App\Models\general;

use CodeIgniter\Model;

class BudgetChild1Model extends Model
{
    protected $table      = 'budget_child1';
    protected $allowedFields = [
        'unique',
        'parent_id',
        'budget_id',
        'cost_id',
        'account_id',
        'month',
        'quantity',
        'price_contract',
        'price_work',
        'total_contract',
        'total_work',
        'group_industry',
        'level',
        'notes',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
