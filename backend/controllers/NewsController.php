<?php
namespace backend\controllers;


use io\web\Url;

use common\models\NewsItem;
use common\models\NewsCategory;
use common\models\NewsContent;
use common\models\search\NewsItemSearch;
use common\models\search\NewsCategorySearch;

class NewsController extends \io\web\Controller{

    public function rules(){
        return [
            [
                'actions' => ['*'],
                'can' => ['backend'],
                'on' => [
                    'allow' => true,
                    'deny' => '/login'
                ]
            ]
        ];
    }

    public function beforeAction($id){
        $this->theme = 'theme-news';

        return true;
    }

    public function actionIndexItem(){

        $searchModel = NewsItemSearch::search( ($_POST) ? $_POST : [] );

        return $this->render('index-item', [
            'searchModel' => $searchModel,
            'dataSet' => $searchModel->dataSet
        ]);
    }
    public function actionViewItem($id = null){
        if($id){
            $model = NewsItem::find()->where([
                '=' => [
                    'id' => $id
                ],
            ])->one();

        } else {
            $model = new NewsItem();
        }
        if($_POST){
            if($model->load($_POST) && $model->validate() && $model->save() && $model->saveContent()){
                \IO::$app->setFlash('Saved!');
                return $this->redirect( Url::to('/news/view-item', ['id' => $model->id]) );
            } else {
                \IO::$app->setFlash('Could not save!');
            }
        }

        return $this->render('view-item', [
            'model' => $model
        ]);
    }

    public function actionIndexCategory(){
        $searchModel = NewsCategorySearch::search( ($_POST) ? $_POST : [] );

        return $this->render('index-category', [
            'searchModel' => $searchModel,
            'dataSet' => $searchModel->dataSet
        ]);
    }

    public function actionViewCategory($id = null){
        if($id){
            $model = NewsCategory::find()->where([
                '=' => [
                    'id' => $id
                ],
            ])->one();

        } else {
            $model = new NewsCategory();
        }
        if($_POST){
            $redirect = $model->isNewModel;
            if($model->load($_POST) && $model->validate() && $model->save()){
                \IO::$app->setFlash('Saved!');
                if($redirect){
                    return $this->redirect( Url::to('/news/view-category', ['id' => $model->id]) );
                }

            } else {
                \IO::$app->setFlash('Could not save!');
            }
        }        
        return $this->render('view-category', [
            'model' => $model
        ]);
    }
    public function actionDeleteItem($ids = []){
        $success = true;
        foreach(json_decode($ids) as $id){
            $model = NewsItem::find()->where([
                '=' => [
                    'id' => $id
                ],
            ])->one();
            if($model && $model->delete()){
                continue;
            } else {
                $success = false;
                break;
            }
        }
        if($success){
            return $this->redirect('/news/index-item');
        }
    }
    public function actionDeleteCategory($ids = []){
        $success = true;
        foreach(json_decode($ids) as $id){
            $model = NewsCategory::find()->where([
                '=' => [
                    'id' => $id
                ],
            ])->one();
            if($model && $model->delete()){
                continue;
            } else {
                $success = false;
                break;
            }
        }
        if($success){
            return $this->redirect('/news/index-category');
        }
    }


    public function actionNewContent(){
        if($_POST){
            $news_item_id = $_POST['news_item_id'];
            $type = $_POST['type'];
            $newsContent = new NewsContent();
            $newsContent->news_item_id = $news_item_id;
            $newsContent->type = $type;
            $newsContent->content = "";
            $newsContent->save();
        }
    }
    public function actionRemoveContent(){
        if($_POST){
            $newsContent = NewsContent::find()->where([
                '=' => [
                    'id' => $_POST['news_content_id']
                ],
            ])->one();
            if($newsContent){
                $r = $newsContent->delete();
            }
        }
    }
    public function actionNewCategory(){
        if($_POST){
            $newsCategory = new NewsCategory();
            $newsCategory->url = $_POST['url'];
            $newsCategory->title = $_POST['title'];
            $newsCategory->save();
        }
    }
}

?>
