<?php
namespace frontend\controllers;

use common\models\NewsItem;
use common\models\search\NewsItemSearch;
use common\models\NewsCategory;
use common\models\search\NewsCategoryItemSearch;

class DocumentationController extends \io\web\Controller{
    public function actionIndex(){
        // return $this->render('index');
        // $newsCategory = NewsCategory::find()->where([
        //     '=' => [
        //         'url' => $category,
        //     ],
        // ])->one();
        // if($newsCategory){
        $searchModel = NewsItemSearch::search( ($_POST) ? $_POST : [] );
        return $this->render('category', [
            // 'newsCategory' => $newsCategory,
            'searchModel' => $searchModel,
            'dataSet' => $searchModel->dataSet
        ]);
        // }
    }
    public function actionCategory($category = null){
        $newsCategory = NewsCategory::find()->where([
            '=' => [
                'url' => $category,
            ],
        ])->one();
        if($newsCategory){
            $searchModel = NewsCategoryItemSearch::search( ($_POST) ? $_POST : [] );
            return $this->render('category', [
                'newsCategory' => $newsCategory,
                'searchModel' => $searchModel,
                'dataSet' => $searchModel->dataSet
            ]);
        }
    }
    public function actionItem($category = null, $item = null){
        $newsCategory = NewsCategory::find()->where([
            '=' => [
                'url' => $category,
            ],
        ])->one();
        if($newsCategory){
            $newsItem = NewsItem::find()->where([
                '=' => [
                    'url' => $item,
                    'news_category_id' => $newsCategory->id
                ]
            ])->one();
            if($newsItem){
                return $this->render('item', [
                    'newsItem' => $newsItem,
                    'newsCategory' => $newsCategory
                ]);
            }
        }
    }
}
?>
