<?php
namespace io\base;

class Asset{
    public $js = [];
    public $css = [];

    public static function className(){
        return get_called_class();
    }
}

?>
