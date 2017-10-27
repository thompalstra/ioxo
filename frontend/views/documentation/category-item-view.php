<?php
use io\widgets\Breadcrumb;
use common\models\NewsContent;
?>
<div class='col xs12 header header-default theme default'>
<div class='container'>
    <?=Breadcrumb::widget([
        'items' => [
            [
                'url' => '/',
                'label' => 'Home'
            ],
            [
                'url' => '/documentation/' . $newsCategory->url,
                'label' => $newsCategory->title
            ],
            [
                'url' => '/documentation/' . $newsCategory->url . '/' . $newsItem->url,
                'label' => $newsItem->title
            ]
        ],
        'options' => [
            'class' => 'breadcrumb breadcrumb-default'
        ],
        'itemOptions' => [
            'class' => 'item'
        ],
    ])?>
    <h1><?=$newsItem->title?></h1>
</div>
</div>
<div class='container'>
    <?php foreach($newsItem->content->all() as $content) { ?>
        <div class='article-block col xs12'>
        <<?=NewsContent::$types[$content->type]?>>
                    <?=$content->content?>
        </<?=NewsContent::$types[$content->type]?>>
        </div>
    <?php } ?>
</div>
<style>
    .article-block{
        margin: 10px 0;
    }
</style>
