<?php
namespace scope\base;

use Scope;

class Model extends \scope\core\Base{

    public $isNewRecord = true;

    public function __construct( $args = [] ){

        foreach( $args as $k => $v){
            $this->$k = $v;
        }

        if( method_exists( $this, 'tableName' ) ){
            foreach( $this->showColumns() as $columnName ){
                if( !property_exists( $this, $columnName ) ){
                    $this->$columnName = null;
                }
                $this->_oldAttributes[$columnName] = $this->_attributes[$columnName] = $this->$columnName;
                $this->$columnName = &$this->_attributes[$columnName];
            }
        }

        if( isset( $args['isNewRecord'] ) && $args['isNewRecord'] == false ){
            call_user_func_array( [ $this, 'onAfterFind' ], [] );
        }
    }

    public function showColumns(){
        return Scope::query()->showColumns( $this->tableName() );
    }

    public function onAfterFind(){
        $this->runBehaviours( 'afterFind' );
        call_user_func_array( [ $this, 'runBehaviours'], [ 'afterFind' ]);
        call_user_func_array( [ $this, 'afterFind' ], [] );
    }

    public function onBeforeSave(){
        $this->runBehaviours( 'beforeSave' );
        call_user_func_array( [ $this, 'runBehaviours'], [ 'beforeSave' ]);
        call_user_func_array( [ $this, 'beforeSave' ], [] );
    }

    public function save( $validate = true ){
        if( $validate && !$this->validate() ){
            return;
        }

        call_user_func_array( [ $this, 'onBeforeSave' ], [] );

        if( $this->isNewRecord ){
            return $this->createRecord();
        } else {
            return $this->updateRecord();
        }
    }
    public function createRecord(){

        $lines = [];

        $tableName = $this->tableName();

        $lines[] = "INSERT INTO $tableName";

        $columns = [];
        $values = [];

        foreach( $this->_attributes as $k => $v ){
            $columns[] = $k;
            $values[] = Scope::query()->createValue( $v );
        }

        $lines[] = "( " . implode(', ', $columns) . " )";
        $lines[] = "VALUES ( " . implode(', ', $values) . " )";

        $command = implode(' ', $lines);

        $sth = Scope::$app->db->conn->prepare( $command );
        $r = $sth->execute();
        if( $r == true ){
            $this->id = Scope::$app->db->conn->lastInsertId();
        }
    }
    public function updateRecord(){
        $set = [];
        $where = '';
        foreach( $this->_attributes as $k => $v ){
            $set[$k] = $this->$k;
        }
        $where = "id = $this->id";
        return Scope::query()->updateAll( self::className(), $set, $where );
    }

    public function afterFind(){}
    public function beforeSave(){}

    public function behaviours(){
        return [];
    }

    public function runBehaviours( $type ){

        $behaviours = $this->behaviours();

        if( isset( $behaviours[$type] ) ){
            foreach( $behaviours[$type] as $behaviour ){
                call_user_func_array( [ $this, 'runBehaviour' ], [ $type, $behaviour ] );
            }
        }
    }
    public function runBehaviour( $type, $behaviour ){
        $fn = 'on' . ucwords( $type );
        $options = [];
        if( isset( $behaviour[1] ) ){
            $options = $behaviour[1];
        }

        $className = $behaviour[0];
        $behaviour = new $className();

        call_user_func_array( [ $behaviour, $fn ], [ $options, $this ] );
    }
}
?>
