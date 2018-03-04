<?php
namespace scope\data;

class ModelDataProvider extends \scope\core\Base{

    public $query;

    public function getModels(){
        if( $this->pagination !== false ){

        }
        return $this->query->all();
    }
}

?>
