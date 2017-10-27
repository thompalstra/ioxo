<?php
namespace frontend\controllers;

use common\models\NewsItem;
use common\models\search\NewsItemSearch;
use common\models\NewsCategory;
use common\models\search\NewsCategoryItemSearch;
use common\models\search\NewsCategorySearch;

class DocumentationController extends \io\web\Controller{
    public function actionIndex(){
        $searchModel = NewsCategorySearch::search( ($_POST) ? $_POST : [] );
        return $this->render('category-index', [
            'searchModel' => $searchModel,
            'dataSet' => $searchModel->dataSet
        ]);
    }
    public function actionCategory($category = null){
        $newsCategory = NewsCategory::find()->where([
            '=' => [
                'url' => $category,
            ],
        ])->one();
        if($newsCategory){
            $searchModel = NewsCategoryItemSearch::search( ($_POST) ? $_POST : [] );
            return $this->render('category-item-index', [
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
                return $this->render('category-item-view', [
                    'newsItem' => $newsItem,
                    'newsCategory' => $newsCategory
                ]);
            }
        }
    }
}
?>
