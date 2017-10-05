<?php
namespace io\widgets;

use io\helpers\Html;

class FormField{

    public function __construct($model, $attribute, $form){
        $this->model = $model;
        $this->attribute = $attribute;
        $this->form = $form;
    }

    public $model;
    public $attribute;
    public $form;



    public function getName(){
        $model = $this->model;
        $model = $model::getClass();
        $add = '';
        if(strpos($this->attribute, '[]') !== false){
            $add = '[]';
        }
        $attribute = $this->attribute;

        return $model."[".$attribute."]".$add;
    }

    public function getValue(){
        $attribute = $this->attribute;
        $model = $this->model;
        return $model->$attribute;
    }

    public function textInput($options){
        $label = $this->createInputLabel();
        $input = \io\helpers\Html::textInput(
            $this->getName(),
            $this->getValue(),
            Html::mergeAttributes($options, $this->form->templateOptions['input'])
        );
        $error = $this->createErrorLabel();
        return $this->createRow($label, $input, $error);
    }

    public function passwordInput($options){
        $label = $this->createInputLabel();
        $input = \io\helpers\Html::passwordInput(
            $this->getName(),
            $this->getValue(),
            Html::mergeAttributes($options, $this->form->templateOptions['input'])
        );
        $error = $this->createErrorLabel();
        return $this->createRow($label, $input, $error);
    }

    public function rowBegin(){
        $options = Html::attributes($this->form->templateOptions['rowBegin']);
        return "<div $options>";
    }

    public function createInputLabel(){
        $attributeLabel = $this->model->getAttributeLabel($this->attribute);
        $options = Html::attributes($this->form->templateOptions['label']);
        return "<label $options>$attributeLabel</label>";
    }

    public function createErrorLabel(){
        $errors = $this->model->getErrors();

        $label = "";
        $class = "";
        $options = [];
        $options['class'] = "label label-default hidden";

        if(isset($errors[$this->attribute]) && !empty($errors[$this->attribute])){
            $messages = [];

            foreach($errors[$this->attribute] as $msg){
                $messages[] = $msg;
            }
            $options['class'] = "label label-default error";
            $label = implode(' ', $messages);
        }
        $options = Html::mergeAttributes($options, $this->form->templateOptions['error']);
        $options = Html::attributes($options);
        return "<label $options>$label</label>";
    }

    public function rowEnd(){
        return "</div>";
    }

    public function createRow($label, $input, $error){

        $out = $this->form->template;
        $out = str_replace('{rowBegin}', $this->rowBegin(), $out);
        $out = str_replace('{label}', $label, $out);
        $out = str_replace('{input}', $input, $out);
        $out = str_replace('{error}', $error, $out);
        $out = str_replace('{rowEnd}', $this->rowEnd(), $out);

        return $out;
    }


}
?>
