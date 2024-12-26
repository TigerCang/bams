<?php

namespace App\Models\main;

use CodeIgniter\Model;

class Company1Model extends Model
{
    protected $table      = 'm_company';
    protected $allowedFields = ['unique', 'code', 'initial', 'name', 'law1', 'law2', 'person_id', 'picture', 'is_tax', 'adaptation', 'save_by', 'confirm_by', 'active_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
