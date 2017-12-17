<?php
namespace api\models;

use io\web\User;

class AppChatMessage extends \io\base\Model{
    public static $table = 'app_chat_message';

    public static function outputMessages( $query ){

        $success = true;
        $data = [];

        $messages = [];

        foreach( $query as $appChatMessage ){

            $source = ($appChatMessage->user_id == \IO::$app->user->identity->id ) ? 'self' : 'ext' ;

            $messages[] = [
                'user_id' => $appChatMessage->user_id,
                'source' => $source,
                'type' => $appChatMessage->type,
                'content' => $appChatMessage->content
            ];
        }

        return $messages;
    }

    public static function submit( $post ){
        $message = new self();
        $message->user_id = $post['user_id'];

        if( $post['message']['type'] == 'text' ){
            $message->content = $post['message']['content'];
        } else {
            $fileName = "/web/uploads/" . uniqid() . "/" . md5($post['user_id']);
            $filePath =  \IO::$app->root . "/api/" . $fileName;


            $dir = dirname($filePath);

            mkdir($dir, 777, true);

            $data = $post['message']['content'];

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents( $filePath , $data);

            $message->content = '/api' . $fileName;
        }



        $message->type = $post['message']['type'];
        $message->chat_id = $post['chatId'];
        $message->created_at = time();
        $message->updated_at = time();

        if( $message->save() ){
            $success = true;
        } else {
            $success = false;
        }
        
        return [
            'success' => $success,
            'message' => [
                'source' => 'self',
                'content' => $message->content,
                'type' => $message->type
            ]
        ];
    }

}


?>
