<?php
namespace api\models;

use io\web\User;

class AppChat extends \io\base\Model{
    public static $table = 'app_chat';

    public static function findbyUser( User $user ) {
        $q = AppChat::find()
        ->leftJoin( 'app_chat_user as acu', ['acu.app_chat_id' => 'app_chat.id' ])
        ->where([
            '=' => [
                'user_id' => $user->id
            ]
        ])
        ->limit(10);
        return $q;
    }

    public function getPartnersFromUser( User $user ){
        return AppChatUser::find()
        ->where([
            '=' => [
                'app_chat_id' => $this->id
            ]
        ])
        ->andWhere([
            '<>' => [
                'user_id' => $user->id
            ]
        ]);
    }

    public function getUserCount(){
        return AppChatUser::find()
        ->where([
            'app_chat_id' => $this->id
        ])->count();
    }
}


?>
