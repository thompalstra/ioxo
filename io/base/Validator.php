<?php
namespace io\base;

class Validator{
    public static function required($model, $attribute, $rule){
        $value = $model->$attribute;

        if(empty($value)){
            $model->addError($attribute, "$attribute cannot be empty");
        }
    }
    public static function tinyint($model, $attribute, $rule){
        $model->$attribute = intval(boolval($model->$attribute));
    }
}

?>
