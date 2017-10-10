<?php
namespace backend\controllers;

use io\web\Controller;
use io\web\User;
use io\data\Security;

use common\models\LoginForm;

class DefaultController extends Controller{

    public function rules(){
        return [
            [
                'actions' => ['login', 'logout', 'error'],
                'can' => ['*'],
            ],
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

    public function actionIndex(){
        return $this->render('index');
    }

    public function actionError(){
        return $this->render('error', [
            'exception' => \IO::$app->exception,
        ]);
    }

    public function actionLogin(){
        $model = new LoginForm();
        if($_POST && $model->load($_POST) && $model->validate()){
            $user = User::find()->where([
                '=' => [
                    'username' => $model->username
                ],
            ])->one();
            if($user && $user->can('backend')){
                if(Security::passwordVerify($model->password, $user->password) && \IO::$app->user->identity->login($user)){
                    return $this->redirect('/');
                } else {
                    $model->addError('Incorrect credentials');
                }
            } else {
                $model->addError('No user found matching credentials');
            }
        }
        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout(){
        if(!\IO::$app->user->isGuest){
            \IO::$app->user->identity->logout();
        }
        return $this->redirect('/login');
    }
}
?>
