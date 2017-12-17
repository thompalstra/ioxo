<?php
namespace api\controllers;

use io\web\Controller;
use io\web\User;
use io\data\Security;

use common\models\LoginForm;

use api\models\AppChat;
use api\models\AppChatUser;
use api\models\AppChatMessage;

class MessageController extends Controller{

    public $success = false;
    public $pageSize = 20;

    public function beforeAction($id){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");

        $json = file_get_contents('php://input');
        $_POST = json_decode($json, true);

        $_POST['user_id'] = ( isset($_POST['user_id']) ? $_POST['user_id'] : 4 );

        $user = User::find()->where([
            '=' => [
                'id' => $_POST['user_id']
            ],
        ])->one();

        \IO::$app->user->identity->login( $user );

        return $id;
    }



    public function actionPage(){
        if( !isset($_POST['page']) ){
            $_POST['page'] = 0;
        }
        if( !isset($_POST['chatId'])){
            $_POST['chatId'] = 1;
        }
        if( !isset($_POST['user_id'])){
            $_POST['user_id'] = 4;
        }

        $page = $_POST['page'];
        $chatId = $_POST['chatId'];
        $userId = $_POST['user_id'];
        $timestamp = ( isset($_POST['timestamp']) ? $_POST['timestamp'] : null );

        $this->offset = $page * $this->pageSize;

        $appChatMessages = AppChatMessage::find();
        $appChatMessages->select('app_chat_message.*');
        $appChatMessages->from('(
            select * from app_chat_message order by created_at desc limit 20
        ) app_chat_message');
        $appChatMessages->where([
            '=' => [
                'chat_id' => $chatId
            ]
        ]);
        $appChatMessages->orderBy(['created_at' => 'asc']);

        $appChat = AppChat::find()->where([
            'id' => $chatId
        ])->one();

        $partners = $appChat->getPartnersFromUser( \IO::$app->user->identity );

        if( $partners->count() == 1 ){

            $this->success = true;

            $partner = $partners->one();
            $partnerUser = $partner->user;

            return $this->renderJson( [
                'success' => $this->success,
                'data' => [
                    'partner' => [
                        'id' => $partnerUser->id,
                        'username' => $partnerUser->username
                    ],
                    'messages' => AppChatMessage::outputMessages( $appChatMessages->all() )
                ]
            ] );
        }

        // return $this->renderJson( $data );
    }

    public function actionSubmit(){
        if( $_POST ){
            return $this->renderJson( AppChatMessage::submit( $_POST ) );
        }
    }

    public function actionGetFromTimestamp(){

        $data = [];

        $appChatMessages = AppChatMessage::find();
        $appChatMessages->select('app_chat_message.*');
        $appChatMessages->from('(
            select * from app_chat_message order by created_at desc limit 20
        ) app_chat_message');
        $appChatMessages->where([
            '=' => [
                'chat_id' => $_POST['chatId']
            ]
        ]);
        $appChatMessages->andWhere([
            '<>' => [
                'user_id' => \IO::$app->user->identity->id
            ]
        ]);
        $appChatMessages->andWhere([
            '>' => [
                'created_at' => $_POST['timestamp']
            ],
        ]);
        $appChatMessages->orderBy(['created_at' => 'asc']);

        $this->success = true;

        return $this->renderJson( [
            'success' => $this->success,
            'data' => [
                'messages' => AppChatMessage::outputMessages( $appChatMessages->all() )
            ],
        ] );
    }
}
?>
