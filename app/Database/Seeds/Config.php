<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Config extends Seeder
{
    public function run()
    {
        helper('generate_helper');
        $config_data = [
            ['unique' => create_Unique(), 'mode' => 'A', 'param' => 'level approve', 'value' => '1',], // level approve
            ['unique' => create_Unique(), 'mode' => 'A', 'param' => 'acc budget', 'value' => '1',], // acc budget
            ['unique' => create_Unique(), 'mode' => 'A', 'param' => 'acc request item', 'value' => '1',], // acc request item
            ['unique' => create_Unique(), 'mode' => 'A', 'param' => 'select supplier', 'value' => '1',], // select supplier
            ['unique' => create_Unique(), 'mode' => 'A', 'param' => 'acc sales order', 'value' => '1',], // acc sales order
            ['unique' => create_Unique(), 'mode' => 'A', 'param' => 'acc ticket time', 'value' => '1',], // acc ticket time sheet
            ['unique' => create_Unique(), 'mode' => 'A', 'param' => 'acc invoice', 'value' => '1',], // acc invoice
            ['unique' => create_Unique(), 'mode' => 'B', 'param' => 'folder cash', 'sub_param' => '/attachment kas', 'value' => '2025',], //cash transaction
            ['unique' => create_Unique(), 'mode' => 'B', 'param' => 'folder hrd', 'sub_param' => '/attachment hrd', 'value' => '2025',], //hrd transaction
        ];

        foreach ($config_data as $data) {
            $this->db->table('m_config')->insert($data);
        }
    }
}
