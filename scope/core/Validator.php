<?php
namespace scope\core;

class Validator extends \scope\core\Base{
    public static function validateAttribute( $attribute, $validator, $validatorOptions, $baseModel ){
        $fn = 'as' . ucwords( $validator );
        if( method_exists( get_called_class(), $fn ) ){
            call_user_func_array( [ get_called_class(), $fn ], [ $attribute, $validatorOptions, $baseModel ] );
        } else if( method_exists( $baseModel, $validator ) ) {
            call_user_func_array( [ $baseModel, $validator ], [ $attribute, $validatorOptions, $baseModel ] );
        } else {
            echo "Validator::$fn is not a valid method."; exit();
        }
    }
    public static function asString( $attribute, $options = [], $baseModel ){
        $value = (string)$baseModel->$attribute;
        if( is_string( $value ) ){
            if( isset( $options['minLength'] ) ){
                $minLength = $options['minLength'];
                if( strlen( $value ) < $minLength ){
                    $attributeLabel = $baseModel->getAttributeLabel($attribute);
                    $baseModel->addError($attribute, "$attributeLabel must be larger than or equal to $minLength." );
                }
            }

            if( isset( $options['maxLength'] ) ){
                $maxLength = $options['maxLength'];
                if( strlen( $value ) > $maxLength ){
                    $attributeLabel = $baseModel->getAttributeLabel($attribute);
                    $baseModel->addError($attribute, "$attributeLabel must be smaller than or equal to $maxLength." );
                }
            }
        } else {
            $attributeLabel = $baseModel->getAttributeLabel($attribute);
            $baseModel->addError($attribute, "$attributeLabel is not a valid string." );
        }
    }
    public static function asNumber( $attribute, $options = [], $baseModel ){
        $value = $baseModel->$attribute;
        if( is_numeric ( $value ) ){
            if( isset( $options['min'] ) ){
                $minLength = $options['min'];
                if( $value < $minLength ){
                    $attributeLabel = $baseModel->getAttributeLabel($attribute);
                    $baseModel->addError($attribute, "$attributeLabel must be larger than or equal to $minLength." );
                }
            }

            if( isset( $options['max'] ) ){
                $maxLength = $options['max'];
                if( $value > $maxLength ){
                    $attributeLabel = $baseModel->getAttributeLabel($attribute);
                    $baseModel->addError($attribute, "$attributeLabel must be smaller than or equal to $maxLength." );
                }
            }
        } else {
            $attributeLabel = $baseModel->getAttributeLabel($attribute);
            $baseModel->addError($attribute, "$attributeLabel is not a valid string." );
        }
    }
    public static function asRequired( $attribute, $options = [], $baseModel ){
        $value = $baseModel->$attribute;
        if( empty( $value ) || $value == null ){
            $attributeLabel = $baseModel->getAttributeLabel($attribute);
            $baseModel->addError($attribute, "$attributeLabel cannot be empty." );
        }
    }
}
?>
