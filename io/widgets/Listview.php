<?php
namespace io\widgets;

use io\helpers\Html;

use io\widgets\DataPager;

class Listview extends \io\base\Widget{


    public $options = [
        'class' => 'datatable'
    ];
    public $itemOptions = [
        'class' => 'item',
    ];
    public $pager = [];

    public $summary = [];

    public $columns = [];

    public $output = "";


    public function prepare($options){
        foreach($options as $k => $v){
            $this->$k = $v;
        }
    }
    public $template = '{summary}{listBegin}{items}{listEnd}{pager}';
    public function run(){

        $out = $this->template;
        $out = str_replace('{pager}', $this->pager(), $out);
        $out = str_replace('{summary}', $this->summary(), $out);
        $out = str_replace('{listBegin}', $this->listBegin($this->options), $out);
        $out = str_replace('{items}', $this->items($this->itemOptions), $out);
        $out = str_replace('{listEnd}', $this->listEnd(), $out);

        return $out;
    }

    public function listBegin($options = []){
        $options = Html::attributes($options);

        $out = '';
        $out .= "<div $options>";
        return $out;
    }

    public function summary(){
        $options = $this->summary;
        $options['pagination'] = $this->dataSet->pagination;
        $options['query'] = $this->dataSet->query;

        return DataSummary::widget($options);
    }

    public function pager(){
        if($this->pager !== false && $this->dataSet->pagination !== false){
            $options = $this->pager;
            $options['pagination'] = $this->dataSet->pagination;
            $options['query'] = $this->dataSet->query;
            return DataPager::widget($options);
        }
    }

    public function items($options = []){
        $collections = [];
        $opt = Html::attributes($options);
        foreach($this->dataSet->getAll() as $key => $model){
            $item = "<div $opt>";

            $viewPath = \IO::$app->root . $this->view;

            if (is_array($this->viewParams)) {
                extract($this->viewParams, EXTR_PREFIX_SAME, 'data');
            }

            ob_start();
            include($viewPath);
            $item .= ob_get_contents();
            ob_end_clean();


            $item .= "</div>";

            $collections[] = $item;
        }
        return implode($collections, '');
        // return $items;
    }

    public function listEnd(){
        return "</div>";
    }
}
?>
