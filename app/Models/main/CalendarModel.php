<?php

namespace App\Models\main;

use CodeIgniter\Model;

class CalendarModel extends Model
{
    protected $table      = 'm_calendar';
    protected $allowedFields = ['unique', 'day_date', 'name', 'cut_day', 'save_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
