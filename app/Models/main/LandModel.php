<?php

namespace App\Models\main;

use CodeIgniter\Model;

class LandModel extends Model
{
    protected $table      = 'm_land';
    protected $allowedFields = [
        'unique',
        'code',
        'name',
        'category',
        'standard_id',
        'group_account',
        'invoice',
        'purchase_date',
        'purchase_value',
        'residual_value',
        'depreciation_mode',
        'tool_age',
        'remain',
        'depreciation_value',
        'company_id',
        'region_id',
        'division_id',
        'picture',
        'location',
        'document',
        'notes',
        'is_sale',
        'adaptation',
        'invoice_link',
        'save_by',
        'confirm_by',
        'active_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
