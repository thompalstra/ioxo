<?php
namespace io\web;

class Request{
    public function __construct(){
        foreach($_SERVER as $sK => $sV){
            $this->$sK = $sV;
        }
    }
}
?>
