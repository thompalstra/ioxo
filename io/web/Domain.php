<?php
namespace io\web;

class Domain{

    public $name;
    public $directory;

    public function __construct(){
        $SERVER_NAME = \IO::$app->request->SERVER_NAME;

        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
          $protocol = 'https://';
        }
        else {
          $protocol = 'http://';
        }

        $SERVER_NAME = str_replace($protocol, '', $SERVER_NAME);

        $explode = explode('.', $SERVER_NAME);
        $count = count($explode);

        if($count > 2){
            $this->name = $explode[0];
            $this->directory = \IO::$app->root . DIRECTORY_SEPARATOR . $explode[0];
        } else if($count == 2){
            $this->name = 'frontend';
            $this->directory = \IO::$app->root . DIRECTORY_SEPARATOR . 'frontend';
        }
    }
}
?>
