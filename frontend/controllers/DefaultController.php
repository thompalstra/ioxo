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

    public function actionDownloadMap(){

        //frontend/web/img/56/100x100.png
        $id = $_GET['id'];

        $path = \IO::$app->root . DIRECTORY_SEPARATOR . "frontend/web/img/$id/100x100.png";

        if(file_exists($path)){
            $size = filesize($path);
            header('Content-Description: File Transfer');
            header('Content-Type: image/png');
            header('Content-Disposition: attachment; filename="Image.png"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $size);
            readfile($path);
        }


    }
}
?>
