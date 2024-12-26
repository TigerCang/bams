<?php

namespace App\Models\main;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table      = 'm_project';
    protected $allowedFields = [
        'unique',
        'code',
        'project_name',
        'package_name',
        'on_name',
        'location',
        'province',
        'district',
        'owner',
        'scope',
        'pay_method',
        'category_id',
        'standard_id',
        'contract_date',
        'pho_date',
        'fho_date',
        'vat',
        'income_tax',
        'contract_value',
        'additional_value',
        'extra_value',
        'gross_value',
        'vat_value',
        'income_tax_value',
        'net_value',
        'period_1',
        'period_2',
        'mode_year',
        'company_id',
        'region_id',
        'division_id',
        'consultant',
        'insurance',
        'finance',
        'implementation',
        'notes',
        'adaptation',
        'save_by',
        'confirm_by',
        'active_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
