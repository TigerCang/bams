<?php

namespace App\Models\main;

use CodeIgniter\Model;

class Company3Model extends Model
{
    protected $table      = 'company_person';
    protected $allowedFields = ['unique', 'company_id', 'revision_notes', 'param', 'name', 'identity', 'position', 'address', 'quantity', 'price', 'is_use'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
