<?php

namespace App\Models\main;

use CodeIgniter\Model;

class GroupAccountModel extends Model
{
    protected $table      = 'group_account';
    protected $allowedFields = [
        'unique',
        'source',
        'param',
        'sub_param',
        'name',
        'value',
        'company_id',
        'account1_id',
        'account2_id',
        'account3_id',
        'account4_id',
        'account5_id',
        'notes',
        'set_default',
        'adaptation',
        'save_by',
        'confirm_by',
        'active_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
