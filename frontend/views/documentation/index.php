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
            isset($newsCategory) ? [
                'url' => '/documentation/' . $newsCategory->url,
                'label' => $newsCategory->title
            ] :
            [
                'url' => '/documentation',
                'label' => 'All categories'
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
        'view' => '/frontend/views/listview/news_category_index.php',
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
<style>
    .has-4 .item{
        width: calc( 25% - 10px );
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .has-4 .item.block{
        padding-bottom: calc( 25% - 20px );
    }

    .has-4:nth-child(4n){
        margin-right: 0;
    }

    .article-block{
        margin: 10px 0;
    }

    .listview.news-category-index{

    }

    .listview.news-category-index a{
        text-decoration: none;
        color: inherit;
    }

    .listview.news-category-index .item{
        overflow: hidden;
        background-color: white;
        color: #333;
        transition: all 150ms linear;
        position: relative;
    }
    .listview.news-category-index .item:hover{
        /*color: white;
        border-color: white;
        background-color: #5099bf;*/
    }

    .listview.news-category-index .item a:before{
        content: "";
        background-color: rgba(255,255,255,.8);
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        z-index: 10;
    }
    .listview.news-category-index .item a:after{
        content: "READ MORE";
        width: 50%;
        height: 40px;
        border: 1px solid #5099bf;
        color: #5099bf;
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        margin: auto;
        z-index: 20;
        line-height: 40px;
        text-align: center;
        background-color: white;
    }

    .listview.news-category-index .item a:before,
    .listview.news-category-index .item a:after{
        display: none;
    }
    .listview.news-category-index .item a:hover:before,
    .listview.news-category-index .item a:hover:after{
        display: inherit;
    }

    .listview.news-category-index .item .title{
        margin: 10px 10px 0 10px;
        padding: 0;
        max-height: calc(100% - 10px);
    }

    .listview.news-category-index .item .content{
        margin: 10px 10px 0 10px;
    }
</style>