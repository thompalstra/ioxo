<?php
namespace backend\controllers;

use io\web\Auth;
use io\web\Url;

use common\models\AuthSearch;

class AuthController extends \io\web\Controller{

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
        $this->theme = 'theme-auth';

        return true;
    }

    public function actionIndex(){

        $searchModel = AuthSearch::search( ($_POST) ? $_POST : [] );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataSet' => $searchModel->dataSet
        ]);
    }
    public function actionView(){
        if(isset($_GET['id'])){
            $model = Auth::find()->where([
                '=' => [
                    'id' => $_GET['id']
                ],
            ])->one();

        } else {
            $model = new Auth();
        }
        if($_POST && $model->load($_POST) && $model->validate() && $model->save()){
            return $this->redirect( Url::to('/auth/view', ['id' => $model->id]) );
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }
    public function actionDelete($id){
        $model = Auth::find()->where([
            '=' => [
                'id' => $id
            ],
        ])->one();
        if($model && $model->delete()){
            return $this->redirect('/auth/index');
        }
    }
}

?>
