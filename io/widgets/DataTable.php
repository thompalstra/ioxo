<?php
namespace io\widgets;

use io\helpers\Html;

use io\widgets\DataPager;

class DataTable extends \io\base\Widget{


    public $tableOptions = [
        'class' => 'datatable'
    ];
    public $columnOptions = [
        'class' => 'column'
    ];
    public $rowOptions = [
        'class' => 'row',
    ];
    public $pager = [
        'range' => 2,
    ];

    public $columns = [];

    public $output = "";


    public function prepare($options){
        foreach($options as $k => $v){
            $this->$k = $v;
        }
    }
    public $template = '{tableBegin}{columns}{rows}{tableEnd}{pager}';
    public function run(){

        $out = $this->template;
        $out = str_replace('{pager}', $this->pager(), $out);
        $out = str_replace('{tableBegin}', $this->tableBegin($this->tableOptions), $out);
        $out = str_replace('{columns}', $this->columns($this->columnOptions), $out);
        $out = str_replace('{rows}', $this->rows($this->rowOptions), $out);
        $out = str_replace('{tableEnd}', $this->tableEnd(), $out);

        return $out;
    }

    public function tableBegin($options = []){
        $options = Html::attributes($options);
        return "<table $options>";
    }

    public function columns($options = []){


        $class = new $this->dataSet->query->class;

        $out = "<tr>";

        foreach($this->columns as $index => $column){
            $columnOptions = [];
            if(is_array($column)){
                $label = (isset($column['label']) ? $column['label'] : $index);
                $columnOptions = (isset($column['options']) ? $column['options'] : []);
                $label = $class->getAttributeLabel($label);
            } else {
                $label = $class->getAttributeLabel($column);
            }
            $opt = Html::mergeAttributes($options, $columnOptions);
            $opt = Html::attributes($opt);
            $out .= "<th $opt>$label</th>";
        }

        $out .= "</tr>";

        return $out;
    }

    public function rows($options = []){


        $options = $options;

        $out = "";
        foreach($this->dataSet->getAll() as $key => $item){
            if(is_array($item)){
                (object)$item;
            } else {
                $key = $item->id;
            }
            $opt = $options;
            $options['datakey'] = $key;

            $opt = Html::attributes($options);

            $out .= "<tr $opt>";

            foreach($this->columns as $index => $column){
                $columnOptions = [];
                if(is_array($column)){
                    $columnOptions = (isset($column['options']) ? $column['options'] : []);
                    if(isset($column['value'])){
                        $value = $column['value']($item);
                    } else {
                        $value = $item->$index;
                    }
                } else {
                    $value = $item->$column;
                }
                $columnOptions = Html::attributes($columnOptions);
                $out .= "<td $columnOptions>$value</td>";
            }
            $out .= "</tr>";
        }
        return $out;
    }

    public function pager(){
        if($this->dataSet->pagination !== false){

            $options = $this->pager;
            $options['pagination'] = $this->dataSet->pagination;
            $options['query'] = $this->dataSet->query;
            return DataPager::widget($options);
        }
    }

    public function tableEnd(){

        return "</table>";
    }
}
?>
