<?php

namespace App\Models\main;

use CodeIgniter\Model;

class BranchModel extends Model
{
    protected $table      = 'm_branch';
    protected $allowedFields = [
        'unique',
        'code',
        'name',
        'address',
        'company_id',
        'region_id',
        'division_id',
        'notes',
        'is_sale',
        'adaptation',
        'save_by',
        'confirm_by',
        'active_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
