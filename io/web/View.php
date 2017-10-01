<?php
namespace io\web;

class View{
    public function render($item, $data = []){
        $root = \IO::$app->root;
        $domain = \IO::$app->domain->name;
        $path = ( \IO::$app->controller->path == "" ) ? "" : \IO::$app->controller->path . DIRECTORY_SEPARATOR;

        $view = $root . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . \IO::$app->controller->name . DIRECTORY_SEPARATOR . $path . \IO::$app->action->id . '.php';
        $layout = $root . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . \IO::$app->controller->layout . '.php';
        // var_dump($path); die;
        if(!file_exists($view)){
            throw new \io\exceptions\HttpNotFoundException("View not found: $view");
        }
        if(!file_exists($layout)){
            throw new \io\exceptions\HttpNotFoundException("Layout not found: $layout");
        }

        if (is_array($data)) {
        extract($data, EXTR_PREFIX_SAME, 'data');
        } else {
            $data = $this->data;
        }

        ob_start();
        include($view);
        $content = ob_get_contents();
        ob_end_clean();
        ob_start();
        include ($layout);
        ob_end_flush();
    }

    public function head(){

    }
    public function footer(){

    }
}
?>
