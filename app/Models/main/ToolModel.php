<?php

namespace App\Models\main;

use CodeIgniter\Model;

class ToolModel extends Model
{
    protected $table      = 'm_tool';
    protected $allowedFields = [
        'unique',
        'param',
        'partner_id',
        'code',
        'code2',
        'name',
        'model',
        'brand',
        'category',
        'type',
        'person_id',
        'resource_id',
        'standard_id',
        'group_account',
        'invoice',
        'index_fuel',
        'weight',
        'purchase_date',
        'manufacture_date',
        'register_date',
        'departure_date',
        'depreciation_mode',
        'tool_age',
        'remain',
        'purchase_value',
        'residual_value',
        'rental_value',
        'depreciation_value',
        'company_id',
        'region_id',
        'division_id',
        'company2_id',
        'picture',
        'document',
        'machine',
        'transmission',
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
