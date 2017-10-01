<?php
namespace io\web;

class User extends \io\base\Model implements \io\web\IdentityInterface{
    public static $table = "user";


    public function rules(){
        return [
            [['username', 'password'], 'required'],
            [['is_deleted'], 'tinyint', 'default' => 0],
            [['is_enabled'], 'tinyint', 'default' => 1]
        ];
    }

    public function login(){
        \IO::$app->user->isGuest = false;
        \IO::$app->user->identity = $this;
    }
    public function logout(){
        unset(\IO::$app->user->identity);
    }
}
?>
