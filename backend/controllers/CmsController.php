<?php
namespace backend\controllers;

use Scope;

use common\models\scope\cms\Page;

class CmsController extends \scope\web\Controller{

    public function rules(){
        return [
            [
                ['pages'],
                'allow' => !Scope::$app->identity->isGuest,
                'deny' => Scope::$app->identity->isGuest,
                'onDeny' => function(  $actionId, $rule  ){
                    header("Location: /login");
                    exit();
                }
            ]
        ];
    }

    public function actionPages(){
        $searchModel = new \backend\models\search\Pages();
        $searchModel->load( $_GET );

        if( $_POST && isset( $_POST['update'] ) ){
            foreach( $_POST['update'] as $modelId => $attributes ){

                $model = Scope::query()->from( Page::className() )->where([ 'id' => $modelId ])->one();

                foreach( $attributes as $attribute => $value  ){
                    $model->$attribute = $value;
                }
                $model->save();
            }
        }

        return $this->render( 'pages', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search()
        ] );
    }
}
