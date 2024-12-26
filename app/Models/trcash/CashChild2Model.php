<?php

namespace App\Models\trcash;

use CodeIgniter\Model;

class CashChild2Model extends Model
{
    protected $table      = 'cash_child2';
    protected $allowedFields = ['unique', 'parent_id', 'child_id', 'cost_id', 'account_id', 'debit', 'credit', 'saldo', 'notes'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
