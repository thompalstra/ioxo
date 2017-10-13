<?php
namespace io\base;

use io\base\TranslateMessage;

class Translate extends \io\base\Model{
    public static $table = 'translate';

    public $_messages = [];

    public function rules(){
        return [
            [['messages'], 'safe']
        ];
    }

    public function getMessages(){
        $messages = [];

        $query = TranslateMessage::find()->where([
            '=' => [
                'translate_id' => $this->id,
            ]
        ]);
        foreach($query->all() as $translation){
            $messages[$translation->language] = $translation->message;
        }
        return $messages;
    }

    public function saveMessages(){
        foreach($this->messages as $language => $message){
            $translateMessage = TranslateMessage::find()->where([
                '=' => [
                    'language' => $language,
                    'translate_id' => $this->id
                ],
            ])->one();

            $translateMessage->message = $message;
            $translateMessage->save();
        }
    }
}

?>
