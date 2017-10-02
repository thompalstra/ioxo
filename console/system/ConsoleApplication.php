<?php
namespace console\system;

use io\web\Request;
use io\web\Controller;
use io\web\Action;
use io\web\Domain;
use io\db\DbConnector;


class ConsoleApplication{
    public function start(){
        $this->prepare();

        $this->initialize();

        return $this->parseRequest( $this->handleRequest() );
    }

    public function prepare(){
        $this->root = dirname(dirname(__DIR__));

        include($this->root . DIRECTORY_SEPARATOR . 'io' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'IO.php');
        include($this->root . DIRECTORY_SEPARATOR . 'io' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'autoloader.php');

        \IO::$app = $this;

        $this->request = new Request(false);
        $this->domain = new Domain();
        $this->controller = new Controller();
        $this->action = new Action();
        $this->dbConnector = new DbConnector();
    }

    public function initialize(){
        // common config db

        $commonConfigDbFile = $this->root . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php';

        if(file_exists($commonConfigDbFile)){
            $this->db = include($commonConfigDbFile);

            $this->dbConnector->mysql = $this->db['mysql'];
            $this->dbConnector->username = $this->db['username'];
            $this->dbConnector->password = $this->db['password'];

            $this->dbConnector->connect();
        }
    }

    public function handleRequest(){
        return $_SERVER['argv'][1];
    }
    public function parseRequest($url){
        $c = $this->controller;
        $a = $this->action;
        $this->controller = $c::get($url);
        $this->action = $a::get($url);

        return $this->controller->runAction($this->action->id);
    }

    public function end(){
        exit();
    }
}
?>
