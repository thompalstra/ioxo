<?php
namespace backend\controllers\cms;

use Scope;

use common\models\scope\cms\Page;

class PagesController extends \scope\web\Controller{

    public function rules(){
        return [
            [
                ['view'],
                'allow' => !Scope::$app->identity->isGuest,
                'deny' => Scope::$app->identity->isGuest,
                'onDeny' => function(  $actionId, $rule  ){
                    header("Location: /login");
                    exit();
                }
            ]
        ];
    }

    public function actionView(){

        if( isset( $_GET['id'] ) ){
            $page = Scope::query()->from( Page::className() )->where(['id'=>$_GET['id']])->one();
        } else {
            $page = new Page();
        }

        $language = isset( $_GET['language'] ) ? $_GET['language'] : Scope::$app->language;

        if( $_POST ){
            $page->load($_POST);
            $page->save();
            $url = $_SERVER['REQUEST_URI'];
            header("Location: $url");
            $page->load($_POST);
            $page->save();
        }

        return $this->render( 'view', [
            'model' => $page,
            'language' => $language
        ] );
    }

}
