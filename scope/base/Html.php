<?php
namespace scope\base;

class Html extends \scope\core\Base{
    public static function toAttributeLabel( $attribute ){
        $label = str_replace('_', ' ', $attribute);
        $label = str_replace('-', ' ', $label);
        $label = ucwords($label);
        return $label;
    }

    public static function toCamelCase( $str ){
        $str = str_replace('_', ' ', $str);
        $str = str_replace('-', ' ', $str);
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);
        return $str;
    }
}
?>
