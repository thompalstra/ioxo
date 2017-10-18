<?php
namespace common\models;
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
}
?>
