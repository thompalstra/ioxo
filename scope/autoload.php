<?php
spl_autoload_register(function ($class) {
    if( file_exists( dirname(__DIR__) . DIRECTORY_SEPARATOR . $class . '.php') ){
        include( dirname(__DIR__) . DIRECTORY_SEPARATOR . $class . '.php' );
    }
});
?>
