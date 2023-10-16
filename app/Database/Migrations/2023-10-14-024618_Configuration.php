<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Configuration extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'configuration_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'configuration_value' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('configuration');
    }

    public function down()
    {
        //
    }
}
