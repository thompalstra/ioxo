<?php
namespace io\web;

class View{
    public function render($item, $data = []){
        $root = \IO::$app->root;
        $domain = \IO::$app->domain->name;
        $path = ( \IO::$app->controller->path == "" ) ? "" : \IO::$app->controller->path . DIRECTORY_SEPARATOR;

        \IO::$app->view = $this;

        $view = $root . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . \IO::$app->controller->name . DIRECTORY_SEPARATOR . $path . \IO::$app->action->id . '.php';
        $layout = $root . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . \IO::$app->controller->layout . '.php';
        
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

    public $assets = [
        'head' => [
            'css' => [],
            'js' => []
        ],
        'footer' => [
            'css' => [],
            'js' => []
        ]
    ];
    const POS_HEAD = 'head';
    const POS_FOOTER = 'footer';

    public function head(){
        $head = "";
        foreach($this->assets['head']['css'] as $k => $css){
            $head .= $css;
        }
        foreach($this->assets['head']['js'] as $k => $js){
            $head .= $js;
        }
        return $head;
    }
    public function footer(){
        $footer = "";
        foreach($this->assets['footer']['css'] as $k => $css){
            $footer .= $css;
        }
        foreach($this->assets['footer']['js'] as $k => $js){
            $footer .= $js;
        }
        return $footer;
    }

    public function registerJs($js, $pos = self::POS_FOOTER, $id = null){
        if($id === null){
            $this->assets[$pos]['js'][] = "<script>$js</script>";
        } else {
            $this->assets[$pos]['js'][$id] = "<script id='$id'>$js</script>";
        }

    }
}
?>
