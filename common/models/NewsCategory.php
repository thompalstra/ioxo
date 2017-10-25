<?php
namespace common\models;

use io\helpers\ArrayHelper;

use io\traits\isDeletedTrait;

class NewsCategory extends \io\base\Model{

    use isDeletedTrait;

    public static $table = 'news_category';
    public function rules(){
        return [
            [['title', 'url'], 'required'],
            [['is_deleted'], 'tinyint', 'default' => 0],
            [['is_enabled'], 'tinyint', 'default' => 1]
        ];
    }

    public static function getDataList($addEmpty = false){
        if($addEmpty == true){
            $d = [""=>"No category"];
        } else{
            $d = [];
        }
        return $d + ArrayHelper::map( self::find()->all(), 'id', 'title');
    }
    public function getItems(){

    }
}
?>
