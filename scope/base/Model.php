<?php
namespace scope\base;

use Scope;

class Model extends \scope\core\Base{
    public function __construct( $args = [] ){
        foreach( $args as $k => $v){
            $this->$k = $v;
        }
        foreach( $this as $k => $v ){
            if( $k[0] == '_' || strtolower($k) == 'isnewrecord' ){
                continue;
            }
            $this->_oldAttributes[$k] = $this->_attributes[$k] = $v;
            $this->$k = &$this->_attributes[$k];
        }

        if( isset( $args['isNewRecord'] ) && $args['isNewRecord'] == false ){
            call_user_func_array( [ $this, 'onAfterFind' ], [] );
        }
    }

    public static function tableName(){
        $shortName = self::shortName();
        echo "Missing $shortName::tableName()"; exit();
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
