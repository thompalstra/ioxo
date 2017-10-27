<?php
use io\widgets\Breadcrumb;
use io\widgets\Listview;
use common\models\NewsContent;

?>
<div class='col xs12 header header-default theme default'>
<div class='container'>
    <?php
    ?>
    <?=Breadcrumb::widget([
        'items' => [
            [
                'url' => '/',
                'label' => 'Home'
            ],
            [
                'url' => '/documentation',
                'label' => 'Documentation'
            ],
            [
                'url' => '/documentation/' . $newsCategory->url,
                'label' => $newsCategory->title
            ]
        ],
        'options' => [
            'class' => 'breadcrumb breadcrumb-default'
        ],
        'itemOptions' => [
            'class' => 'item'
        ],
    ])?>
    <h1><?=isset($newsCategory) ? $newsCategory->title : 'All categories' ?></h1>
</div>
</div>
<div class='container'>
    <?=Listview::widget([
        'dataSet' => $dataSet,
        'view' => '/frontend/views/listview/documentation_item.php',
        'viewParams' => [
            'newsCategory' => isset($newsCategory) ? $newsCategory : null
        ],
        'itemOptions' => [
            'class' => 'item block'
        ],
        'options' => [
            'class' => 'listview news-category-index has-4'
        ]

    ])?>
</div>
