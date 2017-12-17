<?php
namespace api\controllers;

use io\web\Controller;
use io\web\User;
use io\data\Security;

use common\models\LoginForm;

use api\models\AppChat;
use api\models\AppChatUser;
use api\models\AppChatMessage;

class ChatController extends Controller{

    public function beforeAction($id){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");

        $json = file_get_contents('php://input');
        $_POST = json_decode($json, true);

        $user = User::find()->where([
            '=' => [
                'id' => $_POST['user_id']
            ],
        ])->one();

        \IO::$app->user->identity->login( $user );

        return $id;
    }


    public function actionIndex(){
        $data = [];

        foreach( AppChat::findByUser( \IO::$app->user->identity )->all() as $appChat ){

            $partners = $appChat->getPartnersFromUser( \IO::$app->user->identity );

            if( $partners->count() == 1 ){

                $partner = $partners->one();
                $partnerUser = $partner->user;

                $lastAppChatMessage = AppChatMessage::find()->where([
                    'app_chat_id' => $appChat->id
                ])->orderBy(['created_at'=>'desc'])->one();

                $unread = 0;

                $message = [];

                $message['id'] = $appChat->id;

                $partner = [];
                $partner['id'] = $partnerUser->id;
                $partner['username'] = $partnerUser->username;

                $message['partner'] = $partner;

                $messages = [];
                $messages['unread'] = 0;

                $last = [];

                if( $lastAppChatMessage ){

                    $last = [
                        'source' => ( $lastAppChatMessage->user_id == $partnerUser->id ) ? 'ext' : 'self',
                        'content' => $lastAppChatMessage->content,
                        'type' => $lastAppChatMessage->type,
                    ];
                } else {
                    $last = [
                        'source' => 'ext',
                        'content' => 'No message history',
                        'type' => 'text',
                    ];
                }

                $messages['last'] = $last;


                $message['messages'] = $messages;


                $data[] = $message;
            } else {

            }
        }

        // echo '<pre>';
        // print_r($data);
        // die;

        return $this->renderJson( $data );
    }
}
?>
