<?php
namespace common\models;

use io\traits\isDeletedTrait;

class NewsContent extends \io\base\Model{

    use isDeletedTrait;

    public static $table = 'news_content';

    public static $types = [
        1 => 'div',
        2 => 'code',
        3 => 'blockquote',
        4 => 'h2',
        5 => 'h4'
    ];

    public function events(){
        return [
            [['\io\events\onBeforeDeleteEvent'],'beforeDelete'],
            [['\io\events\onBeforeUpdateEvent'],'beforeUpdate'],
        ];
    }

    public function rules(){
        return [
            [['content', 'news_item_id'], 'safe'],
            [['is_deleted'], 'tinyint', 'default' => 0],
            [['is_enabled'], 'tinyint', 'default' => 1]
        ];
    }
}
?>
