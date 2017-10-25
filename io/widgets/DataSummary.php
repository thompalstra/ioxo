<?php
namespace io\widgets;

use io\helpers\Html;
use io\web\Url;

class DataSummary extends \io\base\Widget{

    public $options = [
        'class' => 'summary summary-default'
    ];
    public $query;
    public $pagination;

    public function prepare($options = []){
        foreach($options as $k => $v){
            $this->$k = $v;
        }
    }

    public function run(){
        $out = '';
        if($this->pagination !== false){

            $total = $this->query->count();
            $page = $this->pagination['page'] == 1 ? 0 : $this->pagination['page'] - 1;
            $pageSize = $this->pagination['pageSize'];

            $start = ($page * $pageSize) + $pageSize;

            if($start > $total) {
                $start = $total;
            }
            $options = Html::attributes($this->options);
            $out .= "<div $options>";
            $out .= "Showing <strong>$start</strong> out of <strong>$total</strong> results";
            $out .= "</div>";
        }
        return $out;
    }
}
