<?php
namespace frontend\controllers;

use common\models\NewsCategory;
use common\models\NewsItem;

class DocumentationController extends \io\web\Controller{
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionCategory($category = null){
        $newsCategory = NewsCategory::find()->where([
            '=' => [
                'url' => $category,
            ],
        ])->one();
        if($newsCategory){
            return $this->render('category', ['newsCategory' => $newsCategory]);
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
