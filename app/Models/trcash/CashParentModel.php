<?php

namespace App\Models\trcash;

use CodeIgniter\Model;

class CashParentModel extends Model
{
    protected $table      = 'cash_parent';
    protected $allowedFields = [
        'unique',
        'source',
        'object',
        'company_id',
        'region_id',
        'division_id',
        'object_id',
        'document_number',
        'person_id',
        'standard_id',
        'date_request',
        'date_in',
        'revision',
        'level',
        'status',
        'period',
        'is_journal',
        'is_ok',
        'is_tax',
        'attachment',
        'request_by',
        'save_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
