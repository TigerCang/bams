<?php

namespace App\Models\main;

use CodeIgniter\Model;

class SerialModel extends Model
{
    protected $table      = 'm_serial';
    protected $allowedFields = ['unique', 'item_id', 'serial', 'price', 'tool_id', 'repair', 'adaptation', 'save_by', 'confirm_by', 'active_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
