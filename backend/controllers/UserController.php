<?php
namespace backend\controllers;

use io\web\User;
use io\web\Url;

use common\models\UserSearch;

class UserController extends \io\web\Controller{
    public function actionIndex(){

        $searchModel = UserSearch::search( ($_GET) ? $_GET : [] );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataSet' => $searchModel->dataSet
        ]);
    }
    public function actionView(){
        if(isset($_GET['id'])){
            $model = User::find()->where([
                '=' => [
                    'id' => $_GET['id']
                ],
            ])->one();

        } else {
            $model = new User();
        }

        if($_POST && $model->load($_POST) && $model->validate() && $model->save()){
            return $this->redirect( Url::to('/user/view', ['id' => $model->id]) );
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }
}

?>
