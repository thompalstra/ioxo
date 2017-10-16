<?php
namespace io\widgets;

use io\helpers\Html;

class Breadcrumb extends \io\base\Widget{

    public $items = [];
    public $options = [
        'class' => 'breadcrumb breadcrumb-default'
    ];
    public $itemOptions = [
        'class' => 'item'
    ];
    public $separator = " > ";

    public function prepare($options = []){
        foreach($options as $k => $v){
            $this->$k = $v;
        }
    }
    public function run(){
        $out = $this->begin($this->options);
        $out .= $this->items($this->items, $this->itemOptions);
        $out .= $this->end();

        return $out;
    }

    public function begin($options){
        $options = Html::attributes($options);
        $out = "<ul $options>";

        return $out;
    }
    public function items($items = [], $options = []){
        $collection = [];


        foreach($items as $item){

            $out = "";

            $opt = $options;

            $opt = Html::attributes($options);

            if(isset($item['url'])){
                $url = $item['url'];
                $out .= "<a href='$url'>";
            }
            $out .= "<li $opt>";

            $out .= $item['label'];

            $out .= "</li>";

            if(isset($item['url'])){
                $out .= "</a>";
            }

            $collection[] = $out;
        }
        return implode($this->separator, $collection);
    }
    public function end(){
        $out = "</ul>";

        return $out;
    }
}
?>
