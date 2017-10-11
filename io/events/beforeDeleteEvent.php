<?php
namespace io\events;

class beforeDeleteEvent extends \io\base\Event{
    public function prepare($model, $event){
        $this->model = $model;
        $this->event = $event;
    }
    public function run(){
        if($this->model->isNewModel){
            $this->model->is_deleted = 1;
            $this->model->isNewModel = false;
            $this->model->save();
            return true;
        } else {
            return false;
        }
    }
}
?>
