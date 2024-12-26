<?php

namespace App\Models\trgeneral;

use CodeIgniter\Model;

class BudgetChild2Model extends Model
{
    protected $table      = 'budget_child2';
    protected $allowedFields = [
        'unique',
        'object_id',
        'segment_id',
        'parent_cost',
        'resource_id',
        'frequency',
        'quantity',
        'price',
        'total',
        'notes',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
