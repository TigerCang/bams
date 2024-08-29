<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
    public function run()
    {
        $user_data = [
            [
                'idunik' => '31c7e482f3d466a0132766ef1f9aa0f06c64e8cc95acd3077308d8e1a77fcc8f', 'kode' => 'Administrator',
                'password' => '$2y$10$tPzJ1EnbMDtmscyLwCJ.kOCsL3J460jwg4gvZhB8.6xswwBmf4wDq', 'role_id' => '1',
                'act_button' => '111111', 'act_akses' => '1111111111', 'kondisi' => '111',
            ],
        ];

        foreach ($user_data as $data) {
            $this->db->table('m_user')->insert($data);
        }
    }
}
