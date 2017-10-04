<?php
namespace console\migrations;

use io\db\Schema;

use io\web\User;
use io\web\Auth;
use io\web\AuthUser;

class initial extends \io\db\Migration{
    public function up(){
        $this->createTable('user', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_CHAR,
            'password' => Schema::TYPE_CHAR,
            'is_enabled' => Schema::TYPE_BOOLEAN,
            'is_deleted' => Schema::TYPE_BOOLEAN
        ]);
        $this->createTable('auth', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_CHAR,
        ]);

        $this->createTable('auth_user', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INT,
            'auth_id' => Schema::TYPE_INT,
        ]);

        $this->insert('user', [
            'username' => 'admin',
            'password' => \io\data\Security::passwordHash('test2016'),
            'is_enabled' => 1,
            'is_deleted' => 0
        ]);

        $this->insert('auth', [
            'name' => 'backend'
        ]);

        $userId = User::find()->where([
            '=' => [
                'username' => 'admin'
            ],
        ])->one()->id;

        $authId = Auth::find()->where([
            '=' => [
                'name' => 'backend'
            ],
        ])->one()->id;

        $this->insert('auth_user', [
            'user_id' => $userId,
            'auth_id' => $authId
        ]);

    }
    public function down(){
        $this->dropTable('user');
        $this->dropTable('auth');
        $this->dropTable('auth_user');
    }
}
?>
