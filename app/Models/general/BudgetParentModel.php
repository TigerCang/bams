<?php

namespace App\Models\general;

use CodeIgniter\Model;

class BudgetParentModel extends Model
{
    protected $table      = 'budget_parent';
    protected $allowedFields = [
        'unique',
        'source',
        'object',
        'type',
        'company_id',
        'region_id',
        'division_id',
        'object_id',
        'segment_id',
        'document_number',
        'date_start',
        'date_end',
        'revision',
        'level',
        'status',
        'is_use',
        'notes',
        'save_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
