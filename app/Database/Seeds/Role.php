<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Role extends Seeder
{
    public function run()
    {
        $role_data = [
            ['idunik' => '14ac877123104abfaae5c331cca21b705bc983b8b59ad14d9edcc8e7b6ff1b6e', 'nama' => 'Admin', 'kondisi' => '111',],
        ];

        foreach ($role_data as $data) {
            $this->db->table('m_role')->insert($data);
        }
    }
}
