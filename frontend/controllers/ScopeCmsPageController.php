<?php
namespace frontend\controllers;

use Scope;

use common\models\scope\cms\Page;

class ScopeCmsPageController extends \scope\web\Controller{
    public function actionScopeCmsPageView(){

        if( isset( $_GET['language'] ) && in_array( $_GET['language'], Scope::$app->_language->supported ) ){
            Scope::$app->language = $_GET['language'];
        }

        return $this->render('scope-cms-page-view', [
            'page' => Scope::$app->context->page
        ] );
    }
    public function actionScopeCmsPagePreview(){

        if( isset( $_GET['language'] ) && in_array( $_GET['language'], Scope::$app->_language->supported ) ){
            Scope::$app->language = $_GET['language'];
        }

        $model = Scope::query()->from( Page::className() )->where([
            'id' => $_GET['id']
        ])->one();

        Scope::$app->context->page = $model;

        return $this->render('scope-cms-page-view', [
            'page' => Scope::$app->context->page
        ] );
    }
}

?>
