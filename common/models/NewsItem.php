<?php
namespace common\models;

use common\models\NewsContent;
use common\models\NewsCategory;

use io\traits\isDeletedTrait;

class NewsItem extends \io\base\Model{

    use isDeletedTrait;

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

    public function getCategory(){
        $query = NewsCategory::find()->where([
            '=' => [
                'id' => $this->news_category_id
            ],
        ]);
        return $query->one();
    }
    public function getFirstContent(){
        $query = NewsContent::find()->where([
            '=' => [
                'news_item_id' => $this->id,
                'is_deleted' => 0
            ],
        ]);
        $query->orderBy(['sort_index' => 'asc']);
        return $query->one();
    }
    public function getContent(){
        $query = NewsContent::find()->where([
            '=' => [
                'news_item_id' => $this->id,
                'is_deleted' => 0
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

        return true;
    }
}
?>
