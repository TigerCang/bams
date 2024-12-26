<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
    public function run()
    {
        helper('generate_helper');
        $user_data = [
            [
                'unique' => create_Unique(),
                'code' => 'Administrator',
                'password' => password_hash('A1b2c3d4#', PASSWORD_BCRYPT),
                'role_id' => '1',
                'act_button' => '111111',
                'act_access' => '1111111111',
                'adaptation' => '111',
            ],
        ];

        foreach ($user_data as $data) {
            $this->db->table('m_user')->insert($data);
        }
    }
}
