<?php
namespace common\models;

use common\models\NewsContent;

class NewsItem extends \io\web\User{
    public static $table = 'news_item';

    public $content_new = [];
    public $content_old = [];

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
        $query->orderBy(['sort_index' => 'asc']);
        return $query;
    }

    public function saveContent(){
        $i = 0;
        foreach($this->content_old as $id => $v){
            $newsContent = NewsContent::find()->where([
                '=' => [
                    'id' => $id
                ],
            ])->one();
            $newsContent->news_item_id = $this->id;
            $newsContent->content = $v;
            $newsContent->sort_index = $i++;
            $newsContent->save();
        }
    }
}
?>
