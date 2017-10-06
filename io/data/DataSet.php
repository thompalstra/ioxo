<?php
namespace io\data;

class DataSet{

    public $query;
    public $page;
    public $pageSize;

    public function __construct($params){
        foreach($params as $k => $v){
            $this->$k = $v;
        }
    }

    public function getAll(){

        if($this->pagination !== false){
            $page = ( isset($this->pagination['page']) ? $this->pagination['page'] : 1 ) ;
            $pageSize = ( isset($this->pagination['pageSize']) ? $this->pagination['pageSize'] : 1 ) ;


            $limit = $pageSize;
            $offset = ( $limit * ($page - 1) );
            $this->query->limit( $limit );
            $this->query->offset( $offset );

        }
        return $this->query->all();
    }
}
?>
