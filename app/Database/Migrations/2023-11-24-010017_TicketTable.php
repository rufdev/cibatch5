<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TicketTable extends Migration
{
    public function up()
    {   
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
                'null' => false
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false
            ],
            'office_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ],
            'state' => [
                'type' => 'ENUM',
                'constraint' => ['open', 'closed'],
                'null' => false
            ],
            'severity' => [
                'type' => 'ENUM',
                'constraint' => ['low', 'medium', 'high'],
                'null' => false
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'remarks' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false
            ],
            
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('office_id', 'offices', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tickets');

    }

    public function down()
    {
        $this->forge->dropTable('tickets');
    }
}
