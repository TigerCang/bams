<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BudgetParent extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                            => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
                'unsigned'                      => true,
                'auto_increment'                => true,
            ],
            'unique'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'source'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'object'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'type'                          => [ //btl bn dll
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'company_id'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'region_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'division_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'object_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'segment_id'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'document_number'               => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'date_start'                    => [
                'type'                          => 'DATE',
            ],
            'date_end'                      => [
                'type'                          => 'DATE',
            ],
            'revision'                      => [ // addendum, revision 0,0
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'level'                         => [ //level start, now, next
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'status'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'is_use'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'notes'                         => [
                'type'                          => 'TEXT',
            ],
            'save_by'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'created_at'                    => [
                'type'                          => 'DATETIME',
                'null'                          => true,
            ],
            'updated_at'                    => [
                'type'                          => 'DATETIME',
                'null'                          => true,
            ],
            'deleted_at'                    => [
                'type'                          => 'DATETIME',
                'null'                          => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('budget_parent');
    }

    public function down()
    {
        $this->forge->dropTable('budget_parent');
    }
}
