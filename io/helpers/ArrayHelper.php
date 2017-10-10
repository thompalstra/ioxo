<?php
namespace io\helpers;

class ArrayHelper{
    public static function map($array, $key, $value){
        $out = [];
        foreach($array as $item){
            $item = (array)$item;

            $out[$item[$key]] = $item[$value];
        }
        return $out;
    }
}

?>
