<?php
namespace io\widgets;

use io\helpers\Html;

use io\widgets\Form;

class Toolstrip extends \io\base\Widget{
    public $inputOptions = [
        'class' => 'toolstrip toolstrip-default'
    ];

    public $items = [];

    public $form;

    public function prepare($options = []){
        foreach($options as $k => $v){
            $this->$k = $v;
        }

        $this->form = new Form([
            'template' => '{input}',
            'templateOptions' => [
                'rowBegin' => ['class'=>'col dt12 tb12 mb12 xs12'],
                'input' => ['class'=>''],
                'error' => []
            ]
        ]);
    }

    public function run(){
        $out = '';
        foreach($this->value as $item){
            $className = $item['className'];
            $attribute = $item['attribute'];
            $options = (isset($item['options']) ? $item['options'] : []);
            $out .= $this->form->field($this->model, $attribute)->label(false)->widget($className::className(), $options);
        }

        return $out;
    }
}
?>
