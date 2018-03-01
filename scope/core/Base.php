<?php
namespace scope\core;

use scope\base\Html;

class Base{

    protected $_attributes = [];
    protected $_oldAttributes = [];
    protected $_errors = [];

    public function __construct( $arg = [] ){
        foreach( $arg as $k => $v ){
            $this->$k = $v;
        }
    }

    public static function getClassName(){
        $reflection = new \ReflectionClass( get_called_class() );
        return $reflection->getName();
    }
    public static function getShortName(){
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
        return ( empty( $this->_errors ) );
    }
    public function getErrors( $attribute = null ){
        if( $attribute ){
            return isset( $this->_errors[$attribute] ) ? $this->_errors[$attribute] : false;
        } else {
            return $this->_errors;
        }

    }
    public function addError( $attribute, $message ){
        if( !isset( $this->_errors[$attribute]) ){
            $this->_errors[$attribute] = [];
        }
        $this->_errors[$attribute][] = $message;
    }
    public function addErrors( $arg ){
        foreach( $arg as $attribute => $message ){
            $this->addError( $attribute, $message );
        }
    }

    public function load( $arg ){
        if( isset( $arg[ self::getShortName() ] ) && $data = $arg[ self::getShortName() ] ){
            foreach( $data as $k => $v ){
                $this->$k = $v;
            }
        }
    }

    public function validate(){
        $reflectionProperties = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);;
        foreach( $reflectionProperties as $reflectionProperty ){
            $reflectionPropertyName = $reflectionProperty->name;
            $attributeValue = $this->$reflectionPropertyName;
            foreach( $this->attributes() as $attributeRules ){
                $attributes = $attributeRules[0];
                unset($attributeRules[0]);
                $validator = $attributeRules['as'];
                unset($attributeRules['as']);
                $validatorOptions = $attributeRules;

                $r = array_search( $reflectionPropertyName, $attributes );
                if( $index = array_search( $reflectionPropertyName, $attributes ) !== false ){
                    \scope\core\Validator::validateAttribute( $reflectionPropertyName, $validator, $validatorOptions, $this );
                }
            }
        }

        return empty( $this->_errors );
    }
}
?>
