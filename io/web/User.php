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

    public function login($model){

        $identity = new \io\web\Identity;
        $identity->isGuest = false;
        $identity->identity = $model;

        \IO::$app->session['identity'] = $identity;

        return true;
    }
    public function logout(){

        unset(\IO::$app->session['identity']);

        return true;
    }
}
?>
