<?php
namespace backend\controllers;

use io\web\Auth;
use io\web\Url;

use io\base\Translate;
use common\models\search\TranslateSearch;

class TranslateController extends \io\web\Controller{

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
        $this->theme = 'theme-translate';

        return true;
    }

    public function actionIndex(){

        $searchModel = TranslateSearch::search( ($_POST) ? $_POST : [] );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataSet' => $searchModel->dataSet
        ]);
    }
    public function actionView(){
        if(isset($_GET['id'])){
            $model = Translate::find()->where([
                '=' => [
                    'id' => $_GET['id']
                ],
            ])->one();

        } else {
            $model = new Translate();
        }

        if($_POST && $model->load($_POST) && $model->validate() && $model->save() && $model->saveMessages()){
            return $this->redirect( Url::to('/translate/view', ['id' => $model->id]) );
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }
    public function actionDelete($ids = []){
        $success = true;
        foreach(json_decode($ids) as $id){
            $model = Translate::find()->where([
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
            return $this->redirect('/translate/index');
        }
    }
}

?>
