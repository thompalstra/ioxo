<?php
namespace io\widgets;

use io\helpers\Html;
use io\web\Url;

class DataPager extends \io\base\Widget{

    public $pagination = [];
    public $query;

    public $range = 2;

    public $url;
    public $urlParams;

    public $options = [
        'class' => 'pager pager-default'
    ];

    public function prepare($options = []){

        $this->urlParams = $_GET;
        $this->url = \IO::$app->request->SCRIPT_URL;

        foreach($options as $k => $v){
            $this->$k = $v;
        }
    }

    public function setRange(){
        $total= $this->query->count();

        $pageSize = $this->pagination['pageSize'];
        $page = $this->pagination['page'] == 1 ? 0 : $this->pagination['page'];

        $lastPage = ceil($total / $pageSize);

        $rangeStart = $page - $this->range;
        if($rangeStart < 1){
            $rangeStart = 1;
        }
        $rangeEnd = $page + $this->range;
        if($rangeEnd > $lastPage){
            $rangeEnd = $lastPage;
        }

        $this->rangeStart = $rangeStart;
        $this->rangeEnd = $rangeEnd;
        $this->lastPage = $lastPage;
    }

    public function run(){
        $this->query = clone $this->query;

        $this->setRange();

        $out = $this->pagerBegin($this->options);
        $out .= $this->items();
        $out .= $this->pagerEnd();

        return $out;
    }

    public function pagerBegin($options = []){
        $options = Html::attributes($options);
        return "<ul $options>";
    }

    public function items(){
        $out = '';

        $current = $this->rangeStart;
        while($current <= $this->lastPage){
            $params = $this->urlParams;

            $params['page'] = $current;
            $params['pageSize'] = $this->pagination['pageSize'];

            $active = ($current == $this->pagination['page'] || ($this->pagination['page'] == null && $current == 1) ) ? 'active' : '';

            $out .= Html::a("<li class='$active' behaviour='active'>$current</li>", Url::to($this->url, $params), []);
            $current++;
        }

        return $out;
    }

    public function pagerEnd(){
        return "</ul>";
    }
}
