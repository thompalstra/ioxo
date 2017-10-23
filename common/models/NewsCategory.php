<?php
namespace common\models;

use io\helpers\ArrayHelper;

class NewsCategory extends \io\web\User{
    public static $table = 'news_category';
    public function rules(){
        return [
            [['new_password'], 'passwordCreate', 'min' => 6, 'max' => 24],
            [['username', 'password', 'email'], 'required'],
            [['email'], 'email'],
            [['username'], 'number'],
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
}
?>
