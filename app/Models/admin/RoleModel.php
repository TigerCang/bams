<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table      = 'm_role';
    protected $allowedFields = ['unique', 'name', 'menu_1', 'menu_2', 'menu_3', 'menu_4', 'menu_5', 'menu_6', 'menu_7', 'menu_8', 'menu_9', 'adaptation', 'save_by', 'confirm_by', 'active_by'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getRole($id)
    {
        return $this->where(['id' => $id])->first();
    }
}
