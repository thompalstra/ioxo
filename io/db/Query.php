<?php
namespace io\db;

class Query{

    public $select;
    public $from;
    public $method;

    public $arguments = [];

    public function push($key, $data, $glue){

        $this->arguments[] = [
            'key' => $key,
            'glue' => $glue,
            'arguments' => $data
        ];
    }

    public function select($arg){
        $this->select = $arg;
        return $this;
    }

    public function from($arg){
        $this->from = $arg;
        return $this;
    }

    public function where($arguments){
        $this->push('WHERE', $arguments, 'AND');
        return $this;
    }

    public function andWhere($arguments){
        $this->push('AND', $arguments, 'AND');
        return $this;
    }

    public function orWhere($arguments){
        $this->push('OR', $arguments, 'AND');
        return $this;
    }

    public function sanitize($input){
        if($input === NULL){
            return "NULL";
        } else if(is_numeric($input)){
            return $input;
        } else if(is_string($input)){
            return '"' . $input . '"';
        }
    }

    public function insert($arguments){
        $this->push('INSERT', $arguments, '');
        return $this;
    }

    public function toString(){
        $arg = [];
        $arg[] = "SELECT $this->select FROM $this->from";

        foreach($this->arguments as $argKey => $argValue){
            $a = [];

            $key = $argValue['key'];
            $glue = $argValue['glue'];
            foreach($argValue['arguments'] as $type => $data){
                if(is_array($data)){
                    foreach($data as $column => $value){
                        $value = $this->sanitize($value);
                        $a[] = "$column $type $value";
                    }
                } else{
                    $a[] = $data;
                }

            }

            $arg[] = "$key (" . implode(" $glue ", $a) . ")";
        }
        $command = implode(' ', $arg);
        return $command;
    }

    public function execute($command){
        $sth = \IO::$app->dbConnector->pdo->prepare($command);
        $sth->execute();
        return $sth;
    }

    public function one(){
        $sth = $this->execute($this->toString());

        $args = [];

        $sth->setFetchMode(\PDO::FETCH_CLASS, $this->class, [
            $args,
            false
        ]);
        return $sth->fetch();
    }

    public function all(){
        $sth = $this->execute($this->toString());

        $args = [];

        return $sth->fetchAll($this->method, $this->class, [
            $args,
            false
        ]);
    }
}
?>
