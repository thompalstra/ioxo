<?php
namespace scope\core;

use scope\base\Html;

class Base{

    protected $_attributes = [];
    protected $_oldAttributes = [];
    protected $_errors = [];

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
    }

    public static function className(){
        $reflection = new \ReflectionClass( get_called_class() );
        return $reflection->getName();
    }
    public static function shortName(){
        $reflection = new \ReflectionClass( get_called_class() );
        return $reflection->getShortName();
    }

    public function attributes(){ return []; }
    public function attributeLabels(){ return []; }

    public function getAttributeLabel( $attribute ){
        $attributeLabels = $this->attributeLabels();
        if( isset( $attributeLabels[ $attribute ] ) ){
            return $attributeLabels[ $attribute ];
        } else {
            return Html::toAttributeLabel( $attribute );
        }
    }
    public function hasErrors(){
        return ( empty( $this->_errors ) ? false : true );
    }
    public function getErrors( $attribute = null ){
        if( $attribute ){
            return isset( $this->_errors[$attribute] ) ? $this->_errors[$attribute] : false;
        } else {
            return $this->_errors;
        }

    }
    public function addError( $attribute, $message = null ){

        if( empty( $message ) ){
            if( !isset( $this->_errors['_model']) ){
                $this->_errors['_model'] = [];
            }
            $this->_errors['_model'][] = $attribute;
        } else {
            if( !isset( $this->_errors[$attribute]) ){
                $this->_errors[$attribute] = [];
            }
            $this->_errors[$attribute][] = $message;
        }


    }
    public function addErrors( $arg ){
        foreach( $arg as $attribute => $message ){
            $this->addError( $attribute, $message );
        }
    }

    public function load( $arg ){
        if( isset( $arg[ self::shortName() ] ) && $data = $arg[ self::shortName() ] ){
            foreach( $data as $k => $v ){
                $this->$k = $v;
            }
            return true;
        }
        return false;
    }

    public function validate(){
        foreach( $this->attributes() as $attributeRules ){
            $attributes = $attributeRules[0];
            unset($attributeRules[0]);
            $validator = $attributeRules['as'];
            unset($attributeRules['as']);
            $validatorOptions = $attributeRules;
            foreach( $attributes as $attribute ){
                call_user_func_array( [ '\scope\core\Validator', 'validateAttribute'], [$attribute, $validator, $validatorOptions, $this] );
                // if( method_exists( Validator::className(), $validator ) ){
                //     call_user_func_array( ['\scope\core\Validator', $validator], [$attribute, $validator, $validatorOptions, $this] );
                // } else if( method_exists( $this, $validator ) ){
                //     call_user_func_array( [$this, $validator], [$attribute, $validator, $validatorOptions, $this] );
                // }
            }
        }
        return empty( $this->_errors );
    }
}
?>
