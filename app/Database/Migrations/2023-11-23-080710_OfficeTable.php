<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OfficeTable extends Migration
{
    public function up()
    {
       $fields = [
              'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
                'null' => false,
              ],
              'code' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false,
              ],
              'name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false,
              ],
              'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
              ],
              'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
              ],
         ];
         $this->forge->addField($fields);
         $this->forge->addPrimaryKey('id');
         $this->forge->createTable('offices');
    }

    public function down()
    {
        $this->forge->dropTable('offices');
    }
}
