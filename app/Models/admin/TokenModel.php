<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class TokenModel extends Model
{
    protected $table      = 'user_token';
    protected $allowedFields = ['peminta', 'token', 'is_use', 'save_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
