<?php
namespace io\widgets;

use io\helpers\Html;

class Form{

    public function __construct($arguments){

        foreach($arguments as $key => $value){
            $this->$key = $value;
        }

        $options = Html::attributes($this->options);
        echo "<form $options>";
    }

    public $template = "{rowBegin}{label}{input}{error}{rowEnd}";
    public $templateOptions = [
        'rowBegin' => [
            'class' => 'row row-default'
        ],
        'input' => [
            'class' => 'input input-default'
        ],
        'label' => [
            'class' => 'label label-default'
        ],
        'error' => [
            'class' => 'error error-default',
        ],
    ];
    public $options = [];

    public function field($model, $attribute){
        $field = new FormField($model, $attribute, $this);
        return $field;
    }

    public function end(){
        echo '</form>';
    }
}
?>
