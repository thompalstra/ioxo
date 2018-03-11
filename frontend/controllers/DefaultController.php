<?php
namespace frontend\controllers;

use Scope;

class DefaultController extends \scope\web\Controller{
    public function actionError( $exception ){
        return $this->render('error', [
            'exception' => $exception
        ]);
    }
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionWidgets(){
        return $this->renderView( 'widgets' );
    }
    public function actionTools(){
        return $this->renderView( 'tools' );
    }
    public function actionNav(){
        return $this->renderView( 'nav' );
    }
    public function actionApi(){
        return $this->renderView( 'api' );
    }
}
