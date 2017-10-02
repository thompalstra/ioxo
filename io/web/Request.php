<?php
namespace io\web;

class Request{
    public function __construct($isConsole = false){
        foreach($_SERVER as $sK => $sV){
            $this->$sK = $sV;
        }

        if($isConsole == true){
            die;
        }
    }
}
?>
