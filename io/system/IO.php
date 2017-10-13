<?php

use io\base\Translate;
use io\base\TranslateMessage;

class IO{
    static $app;
    public static function translate($category, $message, $sourceLanguage = null){

        if(!$sourceLanguage){
            $sourceLanguage = \IO::$app->language;
        }

        $query = \io\base\Translate::find();
        $query->leftJoin('translate_message as t', ['t.translate_id' => 'translate.id']);

        $query->where([
            '=' => [
                'translate.category' => $category,
                'translate.source_message' => $message
            ]
        ]);

        $translate = $query->one();

        if(!$translate){

            $translate = new Translate();
            $translate->category = $category;
            $translate->source_message = $message;

            $translate->save();

            foreach(\IO::$app->languages as $language){
                $translateMessage = new TranslateMessage();
                $translateMessage->translate_id = $translate->id;
                $translateMessage->language = $language;
                $translateMessage->message = $message;
                $translateMessage->save();
            }
        }
        if(!isset($translate->messages[$sourceLanguage])){
            $translateMessage = new TranslateMessage();
            $translateMessage->translate_id = $translate->id;
            $translateMessage->language = $sourceLanguage;
            $translateMessage->message = $message;
            $translateMessage->save();
        }

        return $translate->messages[$sourceLanguage];
    }
}
?>
