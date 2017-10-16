<?php
namespace frontend\controllers;

use io\web\Controller;
use io\web\User;

use io\data\Security;

use common\models\LoginForm;

class AboutController extends Controller{
    public function actionIoxo(){
        return $this->render('ioxo', []);
    }
    public function actionTheTeam(){
        return $this->render('the-team', []);
    }
}
?>
