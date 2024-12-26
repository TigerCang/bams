<?php

namespace App\Models\main;

use CodeIgniter\Model;

class Company2Model extends Model
{
    protected $table      = 'company_address';
    protected $allowedFields = ['unique', 'company_id', 'status', 'address', 'city', 'phone', 'fax', 'email', 'tax_number'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
