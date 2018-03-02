<?php
namespace scope\base;

class Model extends \scope\core\Base{
    public static function tableName(){
        $shortName = self::shortName();
        echo "Missing $shortName::tableName()"; exit();
    }
}
?>
