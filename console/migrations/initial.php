<?php
namespace console\migrations;

use io\db\Schema;

class initial extends \io\db\Migration{
    public function up(){
        $this->createTable('user', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_CHAR,
            'password' => Schema::TYPE_CHAR,
            'is_enabled' => Schema::TYPE_BOOLEAN,
            'is_deleted' => Schema::TYPE_BOOLEAN
        ]);

        $this->insert('user', [
            'username' => 'BROTHOM',
            'password' => \io\data\Security::passwordHash('test2016'),
            'is_enabled' => 1,
            'is_deleted' => 0
        ]);
    }
    public function down(){
        $this->dropTable('user');
    }
}
?>
