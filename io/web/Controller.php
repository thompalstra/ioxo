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
            unset($explode[count($explode)-1]);
            $name = $explode[count($explode)-1];
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
        if(method_exists($this, $fn) && $this->allowed($id)){
            // return
            return call_user_func_array([$this, $fn], $args);
        } else {
            throw new \io\exceptions\HttpNotFoundException('Page not found');
        }
    }

    public function allowed($id){
        if(method_exists($this, 'rules')){
            $rules = $this->rules();
            foreach($rules as $k => $v){
                var_dump($v); die;
            }

        } else {
            return true;
        }
    }

    public function render($item, $args = []){
        $view = new View();
        return $view->render($item, $args);
    }

    public function redirect($url){
        header("Location: $url");
        \IO::$app->end();
    }
}
?>
