<?php

namespace App\Models\main;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table      = 'm_inventory';
    protected $allowedFields = [
        'unique',
        'code',
        'name',
        'category',
        'location',
        'group_account',
        'invoice',
        'purchase_date',
        'purchase_value',
        'residual_value',
        'depreciation_mode',
        'invent_age',
        'remain',
        'depreciation_value',
        'company_id',
        'region_id',
        'division_id',
        'branch_id',
        'person_id',
        'picture',
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
