<?php
namespace console\migrations;

use io\db\Schema;

class m1513421733_add_app_tables extends \io\db\Migration{
    public function up(){
        $this->createTable('app_chat', [
            'id' => Schema::TYPE_PK,
            'is_suspended' => 'TINYINT(1) NOT NULL DEFAULT 0',

            'created_at' => 'INT(11) NOT NULL',
            'updated_at' => 'INT(11) NOT NULL',
        ]);

        $this->createTable('app_chat_user', [
            'id' => Schema::TYPE_PK,
            'app_chat_id' => 'INT(11) NOT NULL',
            'user_id' => 'INT(11) NOT NULL',
            'is_active' => 'TINYINT(1) NOT NULL DEFAULT 1'
        ]);

        $this->createTable('app_chat_message', [
            'id' => Schema::TYPE_PK,
            'chat_id' => 'INT(11) NOT NULL',
            'user_id' => 'INT(11) NOT NULL',
            'content' => 'VARCHAR(255)',
            'type' => 'ENUM("image","text")',

            'created_at' => 'INT(11) NOT NULL',
            'updated_at' => 'INT(11) NOT NULL',
        ]);

        $this->createTable('app_chat_request', [
            'id' => Schema::TYPE_PK,
            'from_user_id' => 'INT(11) NOT NULL',
            'to_user_id' => 'INT(11) NOT NULL',
            'is_accepted' => 'TINYINT(1) NOT NULL DEFAULT 0'
        ]);
    }
    public function down(){
        $this->dropTable('app_chat');
        $this->dropTable('app_chat_user');
        $this->dropTable('app_chat_message');
        $this->dropTable('app_chat_request');
    }
}
?>
