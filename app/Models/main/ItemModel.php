<?php

namespace App\Models\main;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table      = 'm_item';
    protected $allowedFields = [
        'unique',
        'param',
        'code',
        'part_number',
        'resource_id',
        'name',
        'category',
        'brand',
        'unit',
        'group_account',
        'min_stock',
        'price',
        'mode',
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
