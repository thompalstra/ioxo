<?php
namespace io\base;

use io\data\Security;

class Model extends \io\db\Row{

    public $isNewModel = true;
    public $_errors = [];
    public $_attributes = [];

    public function __construct($arguments = [], $isNewModel = true){
        $this->isNewModel = $isNewModel;
        foreach($arguments as $k => $v){
            $this->$k = $v;
        }
        if(self::tableExists($this::$table)){
            $columns = $this->getColumns();
            $this->_attributes = array_combine($columns,$columns);
            foreach($this->_attributes as $attributeKey => $attributeValue){
                if(!property_exists($this, $attributeKey)){
                    $this->$attributeKey = null;
                }
                $this->_attributes[$attributeKey] = &$this->$attributeKey;
            }
        }
    }

    public function addError($a, $b = null){
        if(!empty($a) && !empty($b)){
            if(!isset($this->_errors[$a])){
                $this->_errors[$a] = [];
            }
            $this->_errors[$a][] = $b;
        } else if(empty($b)) {
            if(!isset($this->_errors['model'])){
                $this->_errors['model'] = [];
            }
            $this->_errors['model'][] = $a;
        }
    }

    public function getErrors(){
        return $this->_errors;
    }

    public function getError($attribute){
        if(isset($this->_errors[$attribute])){
            return $this->_errors[$attribute];
        }
        return false;
    }

    public function hasErrors(){
        return (empty($this->_errors));
    }
    public function hasError($attribute){
        return (isset($this->_errors[$attribute]));
    }

    public static function getClass(){
        $called = get_called_class();
        $explode = explode('\\', $called);
        return $explode[count($explode) - 1];
    }

    public function load($array){

        $className = self::getClass();

        if(\IO::$app->enableCsrfValidation){
            if(isset($array['_csrf']) && Security::validateCsrf($array['_csrf'])){

            } else {
                foreach($this->_attributes as $attr){
                    $attr = null;
                }
                return false;
            }
        }

        if(isset($array[$className])){
            $data = $array[$className];
            foreach($data as $dataKey => $dataValue){
                $this->$dataKey = $dataValue;
            }
            return true;
        }
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

    public function delete(){
        if(!$this->isNewModel){
            $class = self::className();
            $table = $class::$table;

            $pk = $this->getPkColumnName();
            $v = $this->$pk;

            $query = "DELETE FROM $table WHERE $pk = $v";

            $sth = \IO::$app->dbConnector->pdo->prepare($query);
            return $sth->execute();
        }
    }

    public static function deleteAll($arguments = []){
        $class = self::className();
        $table = $class::$table;

        $a = [];

        foreach($arguments as $k => $type){
            foreach($type as $columnKey => $columnValue){
                $a[] = "$columnKey $k $columnValue";
            }
        }

        $a = implode(' ', $a);

        $query = "DELETE FROM $table WHERE $a";

        $sth = \IO::$app->dbConnector->pdo->prepare($query);
        return $sth->execute();
    }

    public function validate(){
        if(method_exists($this, 'rules')){
            foreach($this->rules() as $rule){
                $attributes = $rule[0];
                $validator = $rule[1];
                foreach($attributes as $attribute){
                    if(method_exists('\io\base\Validator', $validator)){
                        \io\base\Validator::$validator($this, $attribute, $rule);
                    } else if(method_exists($this, $validator)) {
                        $this::$validator($this, $attribute, $rule);
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
            if($attributeKey === 'id'){ continue; }
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

        $result = $sth->execute();

        if($result == true){
            $id = \IO::$app->dbConnector->pdo->lastInsertId ();
            $pk = $this->getPkColumnName();
            $item = $class::find()->where([
                '=' => [
                    $pk => $id
                ],
            ])->one();
            foreach($item->_attributes as $k => $v){
                $this->$k = $v;
            }

            return true;
        }
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

    public function getAttributeLabel($attribute){

        if(strpos($attribute, '[]') !== false){
            $add = '[]';
            $attribute = str_replace('[]', '', $attribute);
        }
        if(method_exists($this, 'attributes')){
            $attributes = $this->attributes();
            if(isset($attributes[$attribute])){
                return $attributes[$attribute];
            }
        }
        $attribute = str_replace('_', ' ', $attribute);
        $attribute = ucwords($attribute);
        return $attribute;
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

    public function __get($attribute){
        if(!property_exists($this, $attribute)){
            $attribute = str_replace('_', ' ', $attribute);
            $attribute = ucwords($attribute);
            $attribute = str_replace(' ', '', $attribute);
            $attribute = "get$attribute";

            if(method_exists($this, $attribute)){
                return $this->$attribute();
            }
        }
        throw new \Exception("$attribute not found");
    }
}
?>
