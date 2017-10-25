<?php
namespace io\events;

class onBeforeUpdateEvent extends \io\base\Event{
    public function prepare($model, $event){
        $this->model = $model;
        $this->event = $event;
    }
    public function run(){
        var_dump("before update");
    }
}
?>
