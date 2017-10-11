<?php
namespace io\widgets;

use io\helpers\Html;

class ToolstripList extends \io\base\Widget{
    public $inputOptions = [
        'class' => 'toolstrip list'
    ];

    public $items = [];

    public function prepare($options = []){

        $opt = (isset($options['options']) ? $options['options'] : []);
        if(!empty($opt)){
            foreach($opt as $k => $v){
                $this->$k = $v;
            }
            unset($options['options']);
        }

        foreach($options as $k => $v){
            $this->$k = $v;
        }
    }

    public function run(){
        $out = $this->listBegin($this->inputOptions);
        $out .= $this->items($this->items);
        $out .= $this->listEnd();
        return $out;
    }
    public function listBegin($options = []){
        $options = Html::attributes($options);
        $out = "<div $options>";
        $placeholder = $this->inputOptions['placeholder'];
        $value = "";
        if($this->value != null && isset($this->items[$this->value])){
            $value = ": <strong>" . $this->items[$this->value] . "</strong>";
        }

        $out .= "<div class='value'>$placeholder$value</div>";
        $out .= "<ul class='hidden'>";
        $out .= Html::hiddenInput($this->name, $this->value, []);
        return $out;
    }
    public function items($items = []){
        $out = "";
        foreach($items as $k => $v){
            $active = ( $this->value == $k ) ? 'active' : '';
            $out .= "<li class='$active' value='$k'>$v</li>";
        }
        return $out;
    }
    public function listEnd(){
        return "</ul></div>";
    }
}
?>
