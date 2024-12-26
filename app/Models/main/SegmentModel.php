<?php

namespace App\Models\main;

use CodeIgniter\Model;

class SegmentModel extends Model
{
    protected $table      = 'm_segment';
    protected $allowedFields = ['unique', 'param', 'project_id', 'segment_id', 'branch_id', 'code', 'name', 'distance', 'notes', 'adaptation', 'save_by', 'confirm_by', 'active_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
