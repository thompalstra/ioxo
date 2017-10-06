<?php
namespace io\widgets;

use io\helpers\Html;

class Slidebox extends \io\base\Widget{

    public $inputOptions = [
        'class' => 'slidebox'
    ];

    public $trueText = "Yes";
    public $falseText = "No";
    public $allowIndeterminate = true;

    public function prepare($options = []){
        foreach($options as $k => $v){
            $this->$k = $v;
        }

        $this->allowIndeterminate = ( isset($this->options['allowIndeterminate']) ? $this->options['allowIndeterminate'] : $this->allowIndeterminate );
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
        $indeterminate = ($this->allowIndeterminate === true) ? 'indeterminate' : '';
        $out = "<div class='wrapper $indeterminate'>";
            $out .= "<div class='true'>$this->trueText</div>";
            if($this->allowIndeterminate === true){
                $out .= "<div class='indeterminate'></div>";
            }
            $out .= "<div class='false'>$this->falseText</div>";
        $out .= "</div>";
        return $out;
    }

    public function slideBoxBegin($options = []){

        // $name = isset($options['name']) ? $options['name'] : $this->inputOptions['name'];
        // $value = isset($options['value']) ? $options['value'] : null;
        //
        $options = Html::attributes($options);

        $options['value'] = boolval($options['value']);



        $out = "<div $options>";
        $out .= Html::hiddenInput($this->name, $this->value, []);
        return $out;
    }
    public function slideBoxEnd(){
        return "</div>";
    }
}
?>
