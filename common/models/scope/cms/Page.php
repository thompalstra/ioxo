<?php
namespace common\models\scope\cms;

use Scope;

use common\behaviours\scope\cms\TranslationBehaviour;

class Page extends \scope\base\Model{

    public function behaviours(){
        return [
            'afterFind' => [
                [ TranslationBehaviour::className(), [ 'title','url', 'content'] ]
            ],
            'beforeSave' => [
                [ TranslationBehaviour::className(), [ 'title','url', 'content'] ]
            ]
        ];
    }

    public static function tableName(){
        return "scope_cms_page";
    }

    public function getTitle(){
        return $this->title[ Scope::$app->language ];
    }
    public function getHTML(){
        return $this->content[ Scope::$app->language ];
    }
}

?>
