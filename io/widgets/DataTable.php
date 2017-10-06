<?php
namespace io\widgets;

use io\helpers\Html;

class DataTable extends \io\base\Widget{

    public $tableOptions = [
        'class' => 'datatable'
    ];
    public $columnOptions = [
        'class' => 'column'
    ];
    public $rowOptions = [
        'class' => 'row'
    ];

    public $columns = [];

    public $output = "";


    public function prepare($options){
        foreach($options as $k => $v){
            $this->$k = $v;
        }
    }
    public function run(){
        $out = $this->tableBegin($this->tableOptions);
        $out .= $this->columns($this->columnOptions);
        $out .= $this->rows($this->rowOptions);
        $out .= $this->tableEnd();

        return $out;
    }

    public function tableBegin($options = []){
        $options = Html::attributes($options);
        return "<table $options>";
    }

    public function columns($options = []){
        $options = Html::attributes($options);

        $class = new $this->dataSet->query->class;

        $out = "<tr>";

        foreach($this->columns as $index => $column){
            if(is_array($column)){
                $label = $class->getAttributeLabel($column['label']);
            } else {
                $label = $class->getAttributeLabel($column);
            }
            $out .= "<th $options>$label</th>";
        }

        $out .= "</tr>";

        return $out;
    }

    public function rows($options = []){
        $options = Html::attributes($options);

        foreach($this->dataSet->getAll() as $key => $item){
            if(is_array($item)){
                (object)$item;
            }
            $out = "<tr $options>";

            foreach($this->columns as $index => $column){
                if(is_array($column)){

                    $value = $column['value']($item);
                } else {
                    $value = $item->$column;
                }
                $out .= "<td>$value</td>";
            }
            $out .= "</tr>";
        }
        return $out;
    }

    public function tableEnd(){
        return "</table>";
    }
}
?>
