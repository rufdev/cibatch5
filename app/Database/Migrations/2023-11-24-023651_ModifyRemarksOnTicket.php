<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyRemarksOnTicket extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('tickets', [
            'remarks' => [
                'type' => 'TEXT',
                'null' => true
            ]
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('tickets', [
            'remarks' => [
                'type' => 'TEXT',
                'null' => false
            ]
        ]);
    }
}
