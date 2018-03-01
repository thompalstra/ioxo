<?php
spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    if( file_exists( dirname(__DIR__) . DIRECTORY_SEPARATOR . $class . '.php') ){
        include( dirname(__DIR__) . DIRECTORY_SEPARATOR . $class . '.php' );
    }
});
?>
