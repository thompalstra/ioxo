<?php
namespace io\base;

class Widget implements WidgetInterface{
    public static function widget($options){

        $className = self::className();

        $widget = new $className();

        $widget->prepare($options);

        return $widget->run();
    }

    public function prepare($options = []){}
    public function run(){}

    public static function className(){
        return get_called_class();
    }
}
?>
