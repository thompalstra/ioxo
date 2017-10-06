<?php
namespace io\base;

class Validator{
    public static function required($model, $attribute, $rule){
        $value = $model->$attribute;
        if(empty($value)){
            $attributeLabel = $model->getAttributeLabel($attribute);
            $model->addError($attribute, "$attributeLabel cannot be empty");
        }
    }
    public static function tinyint($model, $attribute, $rule){
        $model->$attribute = intval(boolval($model->$attribute));
    }
}

?>
