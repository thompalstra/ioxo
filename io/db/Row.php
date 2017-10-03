<?php
namespace io\db;

class Row extends \io\db\Query{

    public $class;

    public function __construct($arguments = []){
        foreach($arguments as $argK => $argV){
            $this->$argK = $argV;
        }
    }

    public static function find(){
        $class = self::className();
        $table = $class::$table;
        $query = new self([
            'class' => $class,
            'table' => $table
        ]);

        $query->method = \PDO::FETCH_CLASS;

        $query->select("$table.*");
        $query->from("$table");

        return $query;
    }

    public static function className(){
        return get_called_class();
    }
}
?>
