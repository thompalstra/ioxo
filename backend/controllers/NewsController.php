<?php
namespace backend\controllers;


use io\web\Url;

use common\models\NewsItem;
use common\models\NewsContent;
use common\models\NewsSearch;

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

    public function actionIndex(){

        $searchModel = NewsSearch::search( ($_POST) ? $_POST : [] );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataSet' => $searchModel->dataSet
        ]);
    }
    public function actionView($id = null){
        if($id){
            $model = NewsItem::find()->where([
                '=' => [
                    'id' => $id
                ],
            ])->one();

        } else {
            $model = new NewsItem();
        }
        if($_POST && $model->load($_POST) && $model->validate() && $model->save() && $model->saveContent()){
            return $this->redirect( Url::to('/news/view-news', ['id' => $model->id]) );
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }
    public function actionDelete($ids = []){
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
            return $this->redirect('/news/index');
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
}

?>
