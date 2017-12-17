<?php
namespace api\controllers;

use io\web\Controller;
use io\web\User;
use io\data\Security;

use common\models\LoginForm;

class DefaultController extends Controller{
    public function actionIndex(){
        $object = [
            'a' => 'b'
        ];
        return $this->renderJson( $object );
    }


}
?>
