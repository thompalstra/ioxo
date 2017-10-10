<?php
namespace io\widgets;

use io\helpers\Html;

class ToolstripButton extends \io\base\Widget{
    public $inputOptions = [
        'class' => 'toolstrip button'
    ];

    public $items = [];

    public function prepare($options = []){
        foreach($options as $k => $v){
            $this->$k = $v;
        }
    }

    public function run(){
        return "dsa";
    }
}
?>
