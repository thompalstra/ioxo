<?php
namespace frontend\controllers;

use io\web\Controller;
use io\web\User;

use io\data\Security;

use common\models\LoginForm;

class DefaultController extends Controller{
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
        if($_POST && $model->load($_POST)){
            $user = User::find()->where([
                '=' => [
                    'username' => $model->username
                ],
            ])->one();
            if($user){
                if(Security::passwordVerify($model->password, $user->password) && \IO::$app->user->identity->login($user)){
                    return $this->redirect('/');
                }
            }
            $model->addError('No user found matching credentials');
        }
        return $this->render('login', ['model' => $model]);
    }
    public function actionLogout(){
        if(!\IO::$app->user->isGuest){
            \IO::$app->user->identity->logout();
            return $this->redirect('/');
        } else {
            echo 'cant logout when not logged in'; die;
        }
    }
}
?>
