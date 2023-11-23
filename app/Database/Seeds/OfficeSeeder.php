<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OfficeSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            [
                'code' => 'PICTD',
                'name' => 'PROVINCIAL ICT DIVISION',
            ],
            [
                'code' => 'PAO',
                'name' => 'PROVINCIAL ACCOUNTANTS OFFICE',
            ],
        ];

        $this->db->table('offices')->insertBatch($data);
    }
}
