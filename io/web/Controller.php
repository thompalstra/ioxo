<?php
namespace io\web;

class Controller{

    public $layout = 'main';

    public function __construct(){

    }

    public static function get($url){
        if($url[0] == '/'){
            $url = substr($url, 1, strlen($url));
        }

        $explode = explode('/', $url);
        $count = count($explode);

        $namespace = \IO::$app->domain->name . "\\controllers\\";
        $name = "default";
        $path = "";

        if($count > 1){
            // modify name

            // get the last part of the explode
            $newName = $explode[count($explode)-1];
            unset($explode[count($explode)-1]);

            $path = implode(DIRECTORY_SEPARATOR, $explode);

            // modify path
        }

        $originalName = $name;

        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        $name = $name . 'Controller';
        $path = (($path !== "") ? $path . "\\" : "");

        $className = $namespace . $path . $name;

        if(!class_exists($className)){
            $className = $namespace . 'DefaultController';
        }

        $controller = new $className();
        $controller->path = $path;
        $controller->name = $originalName;

        return $controller;
    }

    public static function translateId($id){
        $fn = str_replace('-', ' ', $id);
        $fn = ucwords($fn);
        $fn = str_replace(' ', '', $fn);

        $fn = 'action' . $fn;

        return $fn;
    }

    public function runAction($id){
        $args = [];
        $fn = self::translateId($id);
        if(method_exists($this, $fn)){
            // return
            return call_user_func_array([$this, $fn], $args);
        } else {
            throw new \io\exceptions\HttpNotFoundException('Page not found');
        }
    }

    public function render($item, $args){
        $view = new View();
        return $view->render($item, $args);
    }
}
?>
