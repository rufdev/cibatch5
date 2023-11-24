<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Correctstateseverity extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('tickets', [
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'severity' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ]
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('tickets', [
            'state' => [
                'type' => 'ENUM',
                'constraint' => ['open', 'closed'],
                'null' => false
            ],
            'severity' => [
                'type' => 'ENUM',
                'constraint' => ['low', 'medium', 'high'],
                'null' => false
            ]
        ]);
    }
}
