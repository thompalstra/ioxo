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
    }

    public static function getModelName( $context ){
        return str_replace('\\', '_', $context::className() );
    }

    public function onBeforeSave( $options, $context ){
        
        $query = Scope::query()->from( Translation::className() );
        $query->where([
            'and',
            [ 'model_name' => self::getModelName( $context ) ],
            [ 'model_id' => $context->id ],
            [ 'IN', 'attribute', $options ]
        ]);

        foreach( $query->all() as $translation ){
            $attribute = $translation->attribute;
            $language = $translation->language;

            $attr = &$context->$attribute;

            $translation->value = $attr[$language];
            $translation->save();
        }
    }
}

?>
