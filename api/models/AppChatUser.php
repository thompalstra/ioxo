<?php
namespace api\models;

use io\web\User;

class AppChatUser extends \io\base\Model{
    public static $table = 'app_chat_user';

    public function getUser(){
        return User::find()->where([
            '=' => [
                'id' => $this->user_id
            ],
        ])->one();
    }
}


?>
