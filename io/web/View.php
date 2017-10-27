<?php
namespace io\web;

class View{


    public function render($item, $data = []){
        $root = \IO::$app->root;
        $domain = \IO::$app->domain->name;
        $path = ( \IO::$app->controller->path == "" ) ? "" : \IO::$app->controller->path . DIRECTORY_SEPARATOR;

        \IO::$app->view = $this;

        $item = str_replace('/', DIRECTORY_SEPARATOR, $item);
        if($item[0] == DIRECTORY_SEPARATOR){
            $item = substr($item, 1, strlen($item));
            $view = $root . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $item . '.php';
        } else {
            $view = $root . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . \IO::$app->controller->name . DIRECTORY_SEPARATOR . $path . $item . '.php';
        }
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
        foreach($this->assets[self::POS_HEAD]['css'] as $k => $css){
            $head .= $css;
        }
        foreach($this->assets[self::POS_HEAD]['js'] as $k => $js){
            $head .= $js;
        }
        return $head;
    }
    public function footer(){
        $footer = "";
        foreach($this->assets[self::POS_FOOTER]['css'] as $k => $css){
            $footer .= $css;
        }
        foreach($this->assets[self::POS_FOOTER]['js'] as $k => $js){
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
    public function registerCss($css, $pos = self::POS_FOOTER, $id = null){
        if($id === null){
            $this->assets[$pos]['css'][] = "<style>$css</style>";
        } else {
            $this->assets[$pos]['css'][$id] = "<style id='$id'>$css</style>";
        }
    }
    public function registerJsFile($js, $pos = self::POS_HEAD, $id = null){
        if($id === null){
            $this->assets[$pos]['js'][] = "<script src='$js'></script>";
        } else {
            $this->assets[$pos]['js'][$id] = "<script id='$id' src='$js'></script";
        }
    }
    public function registerCssFile($css, $pos = self::POS_HEAD, $id = null){
        if($id === null){
            $this->assets[$pos]['css'][] = "<link rel='stylesheet' href='$css'>";
        } else {
            $this->assets[$pos]['css'][$id] = "<link id='$id' rel='stylesheet' href='$css'>";
        }
    }
    public function registerAsset($asset){

        $asset = new $asset();

        foreach($asset->js as $js){
            $this->registerJsFile($js);
        }
        foreach($asset->css as $css){
            $this->registerCssFile($css);
        }
    }
}
?>
