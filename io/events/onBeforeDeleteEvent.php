<?php
namespace io\events;

class onBeforeDeleteEvent extends \io\base\Event{
    public function prepare($model, $event){
        $this->model = $model;
        $this->event = $event;
    }
    public function run(){
        var_dump("before delete");
    }
}
?>
