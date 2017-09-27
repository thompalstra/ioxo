<?php
spl_autoload_register(function ($name) {
    $path = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . $name . '.php';
    if(file_exists($path)){
        include_once($path);
    } else {
        throw new Exception("Unable to load class $name. Class does not found at path: " . $path);
    }
});

?>
