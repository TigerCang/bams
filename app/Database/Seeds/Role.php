<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Role extends Seeder
{
    public function run()
    {
        helper('generate_helper');
        $role_data = [
            [
                'unique' => create_Unique(),
                'name' => 'Admin',
                'menu_1' => 'A01,101,102,103,A02,104,105,106,107',
                'adaptation' => '111',
            ],
        ];

        foreach ($role_data as $data) {
            $this->db->table('m_role')->insert($data);
        }
    }
}
