<?php
namespace io\web;

class Action{
    public function __construct(){

    }

    public static function get($url){
        if($url[0] == '/'){
            $url = substr($url, 1, strlen($url));
        }
        $id = 'index';
        if($url != ''){
            $explode = explode('/', $url);
            $count = count($explode);

            $id = $explode[count($explode) - 1];
        }

        $a = new Action();
        $a->id = $id;

        return $a;
    }
}
?>
