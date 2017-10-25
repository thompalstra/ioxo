<?php
namespace io\traits;
trait isDeletedTrait{
    public function delete(){
        if(!$this->isNewModel){
            $this->is_deleted = 1;
            $this->save();
        }
        return true;
    }
}
?>
