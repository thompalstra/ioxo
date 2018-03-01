<?php
namespace scope\web;

use Scope;

class View extends \scope\core\Base{
    public static function renderFile( $viewFile, $data = [] ){
        $filePath = View::getFilePath( $viewFile );
        extract($data, EXTR_PREFIX_SAME, 'data');
        ob_start();
        require($filePath);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    public static function getFilePath( $file ){

        $file;

        if( $file[0] == '/' || $file[0] == '\\' ){
            $file = Scope::$app->root . $file;
        } else {
            $file = Scope::$app->root . Scope::$app->environment->viewPath . DIRECTORY_SEPARATOR . Scope::$app->controller->controllerId . DIRECTORY_SEPARATOR . $file;
        }

        $formats = ['html', 'php'];

        foreach( $formats as $format ){
            if( file_exists( "$file.$format" ) ){
                $file = "$file.$format";
                break;
            }
        }

        if( !file_exists( $file ) ){
            echo "$file does not exist (404.2)"; exit();
        }
        return $file;
    }
}
?>
