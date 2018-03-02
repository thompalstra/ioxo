<?php
namespace backend\controllers;

use Scope;

class DefaultController extends \scope\web\Controller{
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionError( $exception ){
        return $this->render('error', [
            'exception' => $exception
        ]);
    }
}
?>
