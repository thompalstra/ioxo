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

    public $label = true;

    public function label($boolean){
        $this->label = $boolean;
        return $this;
    }

    public function getName(){
        $model = $this->model;
        $model = $model::getClass();
        $add = '';

        $attribute = $this->attribute;

        if(strpos($attribute, '[]') !== false){
            $add = '[]';
            $attribute = str_replace('[]', '', $attribute);
        }


        return $model."[".$attribute."]".$add;
    }

    public function getValue(){
        $attribute = $this->attribute;

        if(strpos($attribute, '[]') !== false){
            $attribute = str_replace('[]', '', $attribute);
        }

        $model = $this->model;
        return $model->$attribute;
    }

    public function textInput($options = []){
        $label = $this->createInputLabel();
        $options = $this->appendOptions($options);
        $input = \io\helpers\Html::textInput(
            $this->getName(),
            $this->getValue(),
            Html::mergeAttributes($options, $this->form->templateOptions['input'])
        );
        $error = $this->createErrorLabel();
        return $this->createRow($label, $input, $error);
    }

    public function passwordInput($options = []){
        $label = $this->createInputLabel();
        $options = $this->appendOptions($options);
        $input = \io\helpers\Html::passwordInput(
            $this->getName(),
            $this->getValue(),
            Html::mergeAttributes($options, $this->form->templateOptions['input'])
        );
        $error = $this->createErrorLabel();
        return $this->createRow($label, $input, $error);
    }

    public function input($options = [], $innerHtml = ''){
        $label = $this->createInputLabel();
        $options = $this->appendOptions($options);
        $input = \io\helpers\Html::input(
            $this->getName(),
            $this->getValue(),
            Html::mergeAttributes($options, $this->form->templateOptions['input'])
        );
        $error = $this->createErrorLabel();
        return $this->createRow($label, $input, $error);
    }
    public function iconInput($icon, $options = []){
        $label = $this->createInputLabel();
        $options = $this->appendOptions($options);
        $input = \io\helpers\Html::iconInput(
            $icon,
            $this->getName(),
            $this->getValue(),
            Html::mergeAttributes($options, $this->form->templateOptions['input'])
        );
        $error = $this->createErrorLabel();
        return $this->createRow($label, $input, $error);
    }
    public function select($items = [], $options = []){
        $label = $this->createInputLabel();
        $options = $this->appendOptions($options);
        $input = \io\helpers\Html::select(
            $this->getName(),
            $this->getValue(),
            $items,
            Html::mergeAttributes($options, $this->form->templateOptions['input'])
        );
        $error = $this->createErrorLabel();
        return $this->createRow($label, $input, $error);
    }

    public function appendOptions($options){
        $options['id'] = (!isset($options['id']) ? $this->getId() : $options['id']);
        $options['placeholder'] = (!isset($options['placeholder']) ? $this->model->getAttributeLabel($this->attribute) : $options['placeholder']);

        if($this->form->enableClientValidation){
            if(method_exists($this->model, 'rules')){
                $rules = $this->model->rules();
                foreach($rules as $rule){
                    $attributes = $rule[0];
                    $validator = $rule[1];
                    if($key = array_search($this->attribute, $attributes) !== false){
                        $options[$validator] = '';
                        continue;
                    }
                }
            }
        }
        return $options;
    }

    public function getId(){
        $model = $this->model;
        $model = strtolower($model::getClass());
        $attribute = strtolower($this->attribute);
        $attribute = str_replace('-', '_', $attribute);
        return "$model-$attribute";
    }

    public function rowBegin(){
        $options = [];
        if($this->model->hasError($this->attribute)){
            $options['class'] = 'has-error';
        }
        $options = Html::mergeAttributes($options, $this->form->templateOptions['rowBegin']);
        $options = Html::attributes($options);
        return "<div $options>";
    }

    public function createInputLabel(){
        if($this->label === true){
            $attributeLabel = $this->model->getAttributeLabel($this->attribute);
            $options = Html::attributes($this->form->templateOptions['label']);
            return "<label $options>$attributeLabel</label>";
        } else {
            return "";
        }
    }

    public function createErrorLabel(){
        $label = "";
        $class = "";
        $options = [];
        $options['class'] = "error-label hidden";
        if($this->model->hasError($this->attribute)){
            $messages = [];

            foreach($this->model->getError($this->attribute) as $msg){
                $messages[] = $msg;
            }
            $options['class'] = "error-label error";
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

    public function widget($className, $options = []){

        $widget = new $className();
        $opt = [];

        $inputOptions = ( isset($options['inputOptions']) ? $options['inputOptions'] : [] );
        $inputOptions = Html::mergeAttributes( $this->appendOptions($inputOptions), $widget->inputOptions);
        $options = ( isset($options['options']) ? $options['options'] : [] );

        $widget->name = $this->getName();
        $widget->value = $this->getValue();

        $model = $this->model;
        $attribute = $this->attribute;

        $value = $model->$attribute;

        $opt = [
            'model' => $model,
            'options' =>  $options,
            'inputOptions' => $inputOptions,
        ];

        $widget->prepare($opt);


        $options = Html::attributes($this->form->templateOptions['input']);

        $input = "<div $options>" . $widget->run() . "</div>";

        $label = $this->createInputLabel();
        $error = $this->createErrorLabel();
        return $this->createRow($label, $input, $error);
    }
}
?>
