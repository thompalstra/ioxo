<?php
namespace common\behaviours\scope\cms;

use Scope;

use common\models\scope\cms\Translation;

class TranslationBehaviour extends \scope\core\Base {

    public function onAfterFind( $options, $context ){
        $query = Scope::query()->from( Translation::className() );
        $query->where([
            'and',
            [ 'model_name' => self::getModelName( $context ) ],
            [ 'model_id' => $context->id ],
            [ 'IN', 'attribute', $options ]
        ]);

        foreach( $query->all() as $translation ){
            $attribute = $translation->attribute;
            if( !property_exists($context, $attribute ) ){
                $context->$attribute = [];
            }
            $attr = &$context->$attribute;
            $attr[ $translation->language ] = $translation->value;
        }
        // foreach( Scope::$app->_language->supported as $language ){
        //     foreach( $options as $option ){
        //
        //         if( !isset( $context->$option ) ){
        //             $context->$option = [];
        //         }
        //
        //         $attr = &$context->$option;
        //         $attr[ $language ] = null;
        //     }
        // }
    }

    public static function getModelName( $context ){
        return str_replace('\\', '_', $context::className() );
    }

    public function onBeforeSave( $options, $context ){

        foreach( $options as $option ){
            foreach( Scope::$app->_language->supported as $language ){
                $query = Scope::query()->from( Translation::className() );
                $query->where([
                    'and',
                    [ 'model_name' => self::getModelName( $context ) ],
                    [ 'model_id' => $context->id ],
                    [ 'attribute' => $option ],
                    [ 'language' => $language ]
                ]);
                $model = $query->one();

                if( !$model ){
                    $model = new Translation();
                    $model->model_id = $context->id;
                    $model->model_name = self::getModelName( $context );
                    $model->attribute = $option;
                    $model->language = $language;
                }

                $attr = &$context->$option;

                $model->value = $attr[$language];
                $r = $model->save();
            }
        }
    }
}

?>
