<?php
namespace io\widgets;

use io\helpers\Html;

class Form{

    public $template = '{rowBegin}{label}{input}{error}{rowEnd}';
    public $options = [];
    public $enableClientValidation = true;
    public $templateOptions = [
        'rowBegin' => [
            'class' => 'row row-default'
        ],
        'label' => [
            'class' => 'label label-default col dt1 tb2 mb12 xs12',
        ],
        'input' => [
            'class' => 'input input-default col dt11 tb10 mb12 xs12'
        ],
        'error' => [
            'class' => 'label label-default pull-right error-flat',
        ],
    ];

    public function __construct($arguments = []){

        foreach($arguments as $key => $value){
            $this->$key = $value;
        }
    }

    public function begin(){
        $options = Html::attributes($this->options);
        $out = "<form $options>";
        if(\IO::$app->enableCsrfValidation){
            $out .= Html::hiddenInput(
                '_csrf',
                \IO::$app->_csrf->token
            );
        }
        return $out;
    }


    public function field($model, $attribute){
        $field = new FormField($model, $attribute, $this);
        return $field;
    }

    public function errorField($model, $attribute){
        $out = "";
        if(isset($model->_errors[$attribute])){
            $errors = $model->_errors[$attribute];
            if(is_array($errors)){
                foreach($errors as $error){
                    $field = new FormField($model, $attribute, $this);
                    $out .= $field->rowBegin();
                    $out .= $field->createErrorLabel();
                    $out .= $field->rowEnd();
                }
            } else {
                $field = new FormField($model, $attribute, $this);
                $out .= $field->rowBegin();
                $out .= $field->createErrorLabel();
                $out .= $field->rowEnd();
            }
        }
        echo $out;
    }

    public function end(){
        return '</form>';
    }
}
?>
