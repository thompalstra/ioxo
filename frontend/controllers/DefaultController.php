<?php
namespace frontend\controllers;

use io\web\Controller;

class DefaultController extends Controller{
    public function actionIndex(){
        return $this->render('index', [
            'argA' => 'a',
            'argB' => 543
        ]);
    }

    public function actionError(){
        return $this->render('error', [
            'exception' => \IO::$app->exception,
        ]);
    }
}
?>
