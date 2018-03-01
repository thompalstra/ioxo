<?php
namespace frontend\controllers;

use Scope;

class DefaultController extends \scope\web\Controller{
    public function actionError( $exception ){
        return $this->render('error', [
            'exception' => $exception
        ]);
    }
}
