<?php
use io\widgets\Breadcrumb;
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
                'url' => $newsCategory->url,
                'label' => $newsCategory->title
            ],
            [
                'url' => '/' . $newsCategory->url . '/' . $newsItem->url,
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
        <div class='col xs12'>
        <?php echo $content->content; ?>
        </div>
    <?php } ?>
</div>
