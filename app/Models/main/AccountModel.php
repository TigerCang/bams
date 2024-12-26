<?php

namespace App\Models\main;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table      = 'm_account';
    protected $allowedFields = ['unique', 'code', 'name', 'level', 'category', 'parent_id', 'position', 'adaptation', 'save_by', 'confirm_by', 'active_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
