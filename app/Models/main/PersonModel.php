<?php

namespace App\Models\main;

use CodeIgniter\Model;

class PersonModel extends Model
{
    protected $table      = 'm_person';
    protected $allowedFields = [
        'unique',
        'code',
        'eid',
        'name',
        'category',
        'branch_id',
        'location',
        'gender',
        'blood',
        'birth_place',
        'birth_date',
        'address',
        'contact',
        'email',
        'diploma',
        'major',
        'diploma_st',
        'diploma_date',
        'license_type',
        'license_number',
        'license_date',
        'worker',
        'join_date',
        'employee_st',
        'contract_date_1',
        'contract_date_2',
        'out_select',
        'out_date',
        'out_reason',
        'salary_id',
        'position_id',
        'class_id',
        'user_id',
        'supervisor_id',
        'insurance',
        'is_alias',
        'group_account_customer',
        'group_account_supplier',
        'group_account_partner',
        'group_account_employee',
        'company_id',
        'region_id',
        'division_id',
        'picture',
        'notes',
        'adaptation',
        'save_by',
        'confirm_by',
        'active_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
