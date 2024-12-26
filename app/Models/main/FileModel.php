<?php

namespace App\Models\main;

use CodeIgniter\Model;

class FileModel extends Model
{
    protected $table      = 'm_file';
    protected $allowedFields = [
        'unique',
        'param',
        'sub_param',
        'name',
        'name2',
        'company_id',
        'region_id',
        'division_id',
        'value',
        'set_default',
        'adaptation',
        'save_by',
        'confirm_by',
        'active_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
