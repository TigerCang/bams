<?php

namespace App\Models\trcash;

use CodeIgniter\Model;

class CashChild3Model extends Model
{
    protected $table      = 'cash_child3';
    protected $allowedFields = ['unique', 'child_id', 'tax_number', 'tax_period', 'tax_object_id', 'ni_dpp', 'tariff', 'ni_tax', 'document_ref'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
