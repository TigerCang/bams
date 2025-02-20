<?php

namespace App\Models\cash;

use CodeIgniter\Model;

class CashChild1Model extends Model
{
    protected $table      = 'cash_child1';
    protected $allowedFields = [
        'unique',
        'source',
        'parent_id',
        'detail_id',
        'extra',
        'person_id',
        'segment_id',
        'budget_id',
        'cost_id',
        'resource_id',
        'account_id',
        'osm_id',
        'item_id',
        'quantity',
        'price',
        'debit',
        'credit',
        'notes',
        'child_id',
        'mode',
        'in_pph',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
