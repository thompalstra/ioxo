<?php
namespace backend\controllers;

use Scope;

use common\models\scope\cms\Page;

class CmsController extends \scope\web\Controller{
    public function actionPages(){
        $searchModel = new \backend\models\search\Pages();
        $searchModel->load( $_GET );

        if( $_POST && isset( $_POST['update'] ) ){
            foreach( $_POST['update'] as $modelId => $attributes ){

                $model = Scope::query()->from( Page::className() )->where([ 'id' => $modelId ])->one();

                // $model['']

                $model->title['nl'] = 'test';

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
