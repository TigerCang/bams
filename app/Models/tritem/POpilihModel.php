<?php

namespace App\Models\tritem;

use CodeIgniter\Model;

class POpilihModel extends Model
{
    protected $table      = 'po_pilih';
    protected $allowedFields = ['pominta_id', 'poanak_id', 'potawar_id', 'selected_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
