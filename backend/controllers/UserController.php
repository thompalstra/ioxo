<?php
namespace backend\controllers;

use io\web\User;

use common\models\UserSearch;

class UserController extends \io\web\Controller{
    public function actionIndex(){

        $searchModel = UserSearch::search( ($_POST) ? $_POST : [] );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataSet' => $searchModel->dataSet
        ]);
    }
    public function actionView($id = null){
        if($id === null){
            $model = new User();
        } else {
            $model = User::find()->where([
                '=' => [
                    'id' => $id
                ],
            ])->one();
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }
}

?>
