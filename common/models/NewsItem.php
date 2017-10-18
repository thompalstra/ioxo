<?php
namespace common\models;

use common\models\NewsContent;

class NewsItem extends \io\web\User{
    public static $table = 'news_item';

    public $content_new = [];

    public function rules(){
        return [
            [['content_old', 'content_new'], 'safe'],
            [['is_deleted'], 'tinyint', 'default' => 0],
            [['is_enabled'], 'tinyint', 'default' => 1]
        ];
    }

    public function getContent(){
        $query = NewsContent::find()->where([
            '=' => [
                'news_item_id' => $this->id
            ],
        ]);

        return \io\helpers\ArrayHelper::map( $query->all(), 'id', 'content' );
    }

    public function saveContent(){
        foreach($this->content_old as $id => $v){
            $newsContent = NewsContent::find()->where([
                '=' => [
                    'id' => $id
                ],
            ])->one();
            $newsContent->news_item_id = $this->id;
            $newsContent->content = $v;
            $newsContent->save();
        }
        foreach($this->content_new as $id => $v){
            $newsContent = new NewsContent();
            $newsContent->news_item_id = $this->id;
            $newsContent->content = $v;
            $newsContent->save();
        }
    }
}
?>
