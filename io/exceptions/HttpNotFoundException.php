<?php
namespace io\exceptions;

class HttpNotFoundException extends \Exception{

    public $title = "";
    public $message = "";

    public function __construct($message){
        // get default layout
        $defaultLayout = \IO::$app->root . DIRECTORY_SEPARATOR . \IO::$app->domain->name . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'main.php';
        if(!file_exists($defaultLayout)){
            echo "Error! Default layout file missing: $defaultLayout"; \IO::$app->end();
        }

        // get default error view
        $defaultView = \IO::$app->root . DIRECTORY_SEPARATOR . \IO::$app->domain->name . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'error.php';
        if(!file_exists($defaultView)){
            echo "Error! Default view file missing: $defaultView"; \IO::$app->end();
        }

        if(\IO::$app->action->id != NULL && \IO::$app->action->id == 'error'){
            echo 'ERROR EXECUTING ERROR';
            \IO::$app->end();
        }
        $defC = \IO::$app->domain->name . "\\controllers\\DefaultController";
        \IO::$app->controller = new $defC;
        \IO::$app->controller->name = 'default';
        \IO::$app->controller->path = '';
        \IO::$app->action = new \io\web\Action();
        \IO::$app->action->id = 'error';
        \IO::$app->exception = new \Exception($message, 404);

        \IO::$app->controller->runAction(\IO::$app->action->id);
        \IO::$app->end();
    }
}
?>
