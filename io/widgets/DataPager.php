<?php
namespace io\widgets;

use io\helpers\Html;
use io\web\Url;

class DataPager extends \io\base\Widget{

    public $pagination = [];
    public $query;

    public $url;
    public $urlParams;

    public $options = [
        'class' => 'pager pager-default'
    ];

    public $range = 3;
    public $first = '<i class="material-icons icon">&#xE5DC;</i>';
    public $previous = '<i class="material-icons icon">&#xE408;</i>';
    public $next = '<i class="material-icons icon">&#xE409;</i>';
    public $last = '<i class="material-icons icon">&#xE5DD;</i>';

    public function prepare($options = []){
        $this->urlParams = $_GET;
        $this->url = $_SERVER['REQUEST_URI'];
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
        $rangeEnd = ($page == 0 ? 1 : $page) + $this->range;
        if($rangeEnd > $lastPage){
            $rangeEnd = $lastPage;
        }

        $this->rangeStart = $rangeStart;
        $this->rangeEnd = $rangeEnd;
        $this->lastPage = $lastPage;
    }

    public $template = "{pagerBegin}{first}{previous}{items}{next}{last}{pagerEnd}";

    public function run(){
        $this->query = clone $this->query;

        $this->setRange();

        $out = $this->template;
        $out = str_replace('{pagerBegin}', $this->pagerBegin($this->options), $out);
        $out = str_replace('{first}', $this->first(), $out);
        $out = str_replace('{previous}', $this->previous(), $out);
        $out = str_replace('{items}', $this->items(), $out);
        $out = str_replace('{next}', $this->next(), $out);
        $out = str_replace('{last}', $this->last(), $out);
        $out = str_replace('{pagerEnd}', $this->pagerEnd(), $out);
        return $out;
    }

    public function pagerBegin($options = []){
        $options = Html::attributes($options);
        return "<ul $options>";
    }

    public function first(){
        if($this->first != false){
            $params['page'] = 1;
            $params['pageSize'] = $this->pagination['pageSize'];
            $active = ($this->pagination['page'] == 1) ? 'active' : '';
            return Html::a("<li class='$active' behaviour='active'><span>$this->first</span></li>", Url::to($this->url, $params), []);
        }
    }

    public function previous(){
        if($this->previous != false){
            $prev = $this->pagination['page'] - 1;
            if($prev < 1){
                $prev = 1;
                $active = 'active';
            } else {
                $active = '';
            }

            $params['page'] = $prev;
            $params['pageSize'] = $this->pagination['pageSize'];
            return Html::a("<li class='$active' behaviour='active'><span>$this->previous</span></li>", Url::to($this->url, $params), []);
        }
    }

    public function next(){
        if($this->next != false){
            $next = $this->pagination['page'] + 1;
            if($next > $this->lastPage){
                $next = $this->lastPage;
                $active = 'active';
            } else {
                $active = '';
            }

            $params['page'] = $next;
            $params['pageSize'] = $this->pagination['pageSize'];
            return Html::a("<li class='$active' behaviour='active'><span>$this->next</span></li>", Url::to($this->url, $params), []);
        }
    }

    public function last(){
        if($this->last != false){
            $params['page'] = $this->lastPage;
            $params['pageSize'] = $this->pagination['pageSize'];
            $active = ($this->pagination['page'] == $this->lastPage) ? 'active' : '';
            return Html::a("<li class='$active' behaviour='active'><span>$this->last</span></li>", Url::to($this->url, $params), []);
        }
    }

    public function items(){
        $out = '';

        $current = $this->rangeStart;


        while($current <= $this->rangeEnd){
            $params = $this->urlParams;

            $params['page'] = $current;
            $params['pageSize'] = $this->pagination['pageSize'];

            $active = ($current == $this->pagination['page'] || ($this->pagination['page'] == null && $current == 1) ) ? 'active' : '';

            $out .= Html::a("<li class='$active' behaviour='active'><span>$current</span></li>", Url::to($this->url, $params), []);
            $current++;
        }

        return $out;
    }

    public function pagerEnd(){
        return "</ul>";
    }
}
