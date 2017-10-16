<?php
namespace common\models;
class User extends \io\web\User{
    public static $table = 'user';
    public function rules(){
        return [
            [['new_password'], 'passwordCreate', 'min' => 6, 'max' => 24],
            [['username', 'password', 'email'], 'required'],
            [['email'], 'email'],
            [['username'], 'number'],
            [['is_deleted'], 'tinyint', 'default' => 0],
            [['is_enabled'], 'tinyint', 'default' => 1]
        ];
    }

    public function attributes(){
        return [
            'id'                => \IO::translate('io', '#'),
            'role'              => \IO::translate('io', 'Role'),
            'usedRoles'         => \IO::translate('io', 'Used roles'),
            'is_enabled'        => \IO::translate('io', 'Enabled'),
        ];
    }
}
?>
