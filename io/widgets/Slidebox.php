<?php
namespace io\widgets;

use io\helpers\Html;

class Slidebox extends \io\base\Widget{

    public $inputOptions = [
        'class' => 'slidebox'
    ];

    public $trueText = "Yes";
    public $falseText = "No";

    public function prepare($options = []){
        foreach($options as $k => $v){
            $this->$k = $v;
        }
        $this->trueText = ( isset($this->options['trueText']) ? $this->options['trueText'] : $this->trueText );
        $this->falseText = ( isset($this->options['falseText']) ? $this->options['falseText'] : $this->falseText );
    }
    public function run(){


        $out = $this->slideBoxBegin( $this->inputOptions + ['name' => $this->name] );

        $out .= $this->createOptions();
        $out .= $this->slideBoxEnd();

        return $out;
    }

    public function createOptions(){
        $out = "<div class='wrapper'>";
            $out .= "<div class='true'>$this->trueText</div>";
            $out .= "<div class='false'>$this->falseText</div>";
            $out .= "<div class='indicator'></div>";
        $out .= "</div>";
        return $out;
    }

    public function slideBoxBegin($options = []){
        $this->value = boolval($this->value);


        $options = Html::attributes($options);
        $out = "<div $options>";
        $out .= Html::hiddenInput($this->name, $this->value, []);
        return $out;
    }
    public function slideBoxEnd(){
        return "</div>";
    }
}
?>
