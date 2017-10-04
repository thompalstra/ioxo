<?php
namespace backend\controllers;

use io\web\Controller;

class DefaultController extends Controller{

    public function rules(){
        return [
            [
                'on' => ['8'],
                'can' => ['backend']
            ],
        ];
    }

    public function actionIndex(){
        return $this->render('index');
    }

    public function actionError(){
        return $this->render('error', [
            'exception' => \IO::$app->exception,
        ]);
    }

    public function actionLogin(){
        $user = \io\web\User::find()->one();

        $user->login();


        return $this->redirect('/');
    }

    public function actionLogout(){
        return $this->redirect('/');
    }
}
?>
