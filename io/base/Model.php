<?php
namespace io\base;

class Model extends \io\db\Row{

    public $isNewModel = true;
    public $_errors = [];
    public $_attributes = [];

    public function __construct($arguments = [], $isNewModel = true){
        $this->isNewModel = $isNewModel;
        foreach($arguments as $k => $v){
            $this->$k = $v;
        }
        $columns = $this->getColumns();
        $this->_attributes = array_combine($columns,$columns);
        foreach($this->_attributes as $attributeKey => $attributeValue){
            if(!property_exists($this, $attributeKey)){
                $this->$attributeKey = null;
            }
            $this->_attributes[$attributeKey] = &$this->$attributeKey;
        }
    }

    public function addError($attribute, $message){
        if(!isset($this->_errors[$attribute])){
            $this->_errors[$attribute] = [];
        }

        $this->_errors[$attribute][] = $message;
    }

    public function getErrors(){
        return $this->_errors;
    }

    public function hasErrors(){
        return (empty($this->_errors));
    }

    public function getColumns(){
        $class = self::className();
        $sth = \IO::$app->dbConnector->pdo->prepare("DESCRIBE ".\IO::$app->db['mysql']['dbname'].".".$class::$table);
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function save($validate = true){

        $result = false;

        if($validate && !$this->validate()){
            return $result;
        }
        if($this->isNewModel){
            return $this->create();
        } else {
            return $this->update();
        }
    }

    public function validate(){
        if(method_exists($this, 'rules')){
            foreach($this->rules() as $rule){
                $attributes = $rule[0];
                $validator = $rule[1];
                foreach($attributes as $attribute){
                    if(method_exists('\io\base\Validator', $validator)){
                        \io\base\Validator::$validator($this, $attribute, $rule);
                    }
                }
            }
        }

        return ($this->hasErrors());
    }

    public function create(){
        $class = self::className();
        $table = $class::$table;
        $query = "INSERT INTO $table";

        $keys = [];
        $values = [];

        foreach($this->_attributes as $attributeKey => $attributeValue){
            $keys[] = $attributeKey;
            $attributeValue = $this->sanitize($attributeValue);
            $values[] = ":$attributeKey";
        }
        $keys = implode(', ', $keys);
        $values = implode(', ', $values);

        $command = "$query ($keys) VALUES ($values)";
        $sth = \IO::$app->dbConnector->pdo->prepare($command);

        foreach($this->_attributes as $attributeKey => $attributeValue){
            if($attributeKey === 'id'){ continue; }
            $sth->bindValue(":$attributeKey", $attributeValue);
        }

        return $sth->execute();
    }

    public function getPkColumnName(){

        $class = self::className();
        $table = $class::$table;

        $command = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";

        $sth = \IO::$app->dbConnector->pdo->prepare($command);
        $sth->execute();
        $results = $sth->fetch();
        if(is_array($results)){
            return $results['Column_name'];
        } else {
            return false;
        }
    }

    public function update(){
        $class = self::className();
        $table = $class::$table;

        $pk = $this->getPkColumnName();
        if($pk === false){
            throw new \Exception('ERROR! LOL');
        }

        $query = "UPDATE $table";
        $set = [];

        foreach($this->_attributes as $attributeKey => $attributeValue){
            if($attributeKey === 'id'){ continue; }
            $set[] = "`$attributeKey` = :$attributeKey";
        }

        $set = implode(', ', $set);
        $id = $this->_attributes['id'];

        $pkValue = $this->$pk;

        $command = "$query SET $set WHERE $pk = $pkValue";

        $sth = \IO::$app->dbConnector->pdo->prepare($command);

        foreach($this->_attributes as $attributeKey => $attributeValue){
            if($attributeKey === 'id'){ continue; }
            $sth->bindValue(":$attributeKey", $attributeValue);
        }

        return $sth->execute();
    }
}
?>
