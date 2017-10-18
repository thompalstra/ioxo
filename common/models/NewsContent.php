<?php
namespace common\models;
class NewsContent extends \io\web\User{
    public static $table = 'news_content';
    public function rules(){
        return [
            [['content', 'news_item_id'], 'safe'],
            [['is_deleted'], 'tinyint', 'default' => 0],
            [['is_enabled'], 'tinyint', 'default' => 1]
        ];
    }
}
?>
