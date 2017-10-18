<?php
namespace io\web;

class Controller{

    public $layout = 'main';
    public $theme = 'theme-default';

    public function __construct(){

    }
    public function beforeAction($id){ return true; }

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
            throw new \io\exceptions\HttpNotFoundException("Controller not found: $className");
            // $className = $namespace . 'DefaultController';
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

    public function matchArguments($controller, $function, $arguments){
        $f = new \ReflectionMethod(get_class($controller), $function);
        $params = $f->getParameters();

        $result = [];
        $error = [];
        foreach($params as $param){
            $name = $param->name;
            if(isset($arguments[$name])){
                $result[] = $arguments[$name];
            } else {
                $error[] = "Missing required parameter: $name";
            }
        }

        if(!empty($error)){
            throw new \io\exceptions\HttpNotFoundException( implode("\n", $error) );
        }
        return $result;
    }

    public function runAction($id, $args = []){
        $fn = self::translateId($id);

        if(method_exists($this, $fn)){
            if($this->allowed($id)){
                $arg = $this->matchArguments($this, $fn, $args + $_GET);
                if($this->beforeAction($id)){
                    return call_user_func_array([$this, $fn], $arg);
                }
            } else {
                throw new \io\exceptions\HttpNotFoundException('Permission denied');
            }
        } else {
            throw new \io\exceptions\HttpNotFoundException("Could not find $id");
        }
    }

    public function allowed($id){
        if(method_exists($this, 'rules')){
            $rules = $this->rules();
            foreach($rules as $k => $v){
                $actions = $v['actions'];
                $can = $v['can'];

                foreach($actions as $action){
                    if($action == '*' || $action == $id){
                        foreach($can as $role){
                            $result = \IO::$app->user->identity->can($role);
                            if($result === true){
                                if(isset($v['on']) && isset($v['on']['allow'])){
                                    if(is_string($v['on']['allow'])){
                                        $this->redirect($v['on']['allow']);
                                    } else {
                                        return true;
                                    }
                                } else {
                                    return true;
                                }
                            } else if($result === false){
                                if(isset($v['on']) && isset($v['on']['deny'])){
                                    if(is_string($v['on']['deny'])){
                                        return $this->redirect($v['on']['deny']);
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return false;
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
