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
    }
    public function down(){
        $this->dropTable('user');
    }
}
?>
