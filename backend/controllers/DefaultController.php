<?php
namespace backend\controllers;

use Scope;

use common\models\LoginForm;

class DefaultController extends \scope\web\Controller{

    public function rules(){
        return [
            [
                ['index'],
                'allow' => !Scope::$app->identity->isGuest,
                'deny' => Scope::$app->identity->isGuest,
                'onDeny' => function(  $actionId, $rule  ){
                    header("Location: /login");
                    exit();
                }
            ],
            [
                ['error'],
                'allow' => true
            ],
            [
                ['login'],
                'deny' => !Scope::$app->identity->isGuest,
                'onDeny' => function( $actionId, $rule ){
                    header("Location: /");
                    exit();
                }
            ],
            [
                ['logout'],
                'allow' => !Scope::$app->identity->isGuest,
            ]
        ];
    }

    public function actionIndex(){
        return $this->render('index');
    }
    public function actionError( $exception ){
        return $this->render('error', [
            'exception' => $exception
        ]);
    }

    public function actionLogout(){
        Scope::$app->identity->logout();
        header("Location: /");
        exit();
    }

    public function actionLogin(){

        $loginForm = new LoginForm();

        if( $_POST && $loginForm->load( $_POST ) ){

            $success = false;
            $message = "";
            $data = [];

            if( $loginForm->validate() ){
                $loginForm->login( $loginForm->user );
                $success = true;
                $message = "Please wait while we configure some stuff";
                $data['href'] = '/';
            } else {
                $errors = [];
                foreach( $loginForm->getErrors() as $attributes ){
                    foreach( $attributes as $k => $v ){
                        $errors[] = $v;
                    }
                }
                $message = implode("\n", $errors);
            }

            return $this->json([
                'success' => $success,
                'message' => $message,
                'data' => $data
            ]);
        }

        return $this->render('login', [
            'loginForm' => $loginForm
        ]);
    }
}
?>
