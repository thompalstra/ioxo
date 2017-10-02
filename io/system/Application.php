<?php
namespace io\system;

use io\web\Request;
use io\web\Domain;
use io\web\Controller;
use io\web\Action;

use io\db\DbConnector;

class Application{

    public function prepare(){

        $this->root = dirname(dirname(__DIR__));

        include($this->root . DIRECTORY_SEPARATOR . 'io' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'IO.php');
        include($this->root . DIRECTORY_SEPARATOR . 'io' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'autoloader.php');

        \IO::$app = $this;

        $this->request = new Request();
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



        // env config.php

        $domainConfigFile = $this->domain->directory . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';
        if(file_exists($domainConfigFile)){
            // $this->db = include($commonConfigDbFile);
            foreach(include($domainConfigFile) as $k => $v){
                $this->$k = $v;
            }
        }



        // env params.php

        $domainParamFile = $this->domain->directory . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

        if(file_exists($domainParamFile)){
            foreach(include($domainParamFile) as $k => $v){
                $this->params[$k] = $v;
            }
        }

        session_start();
        $sessionUser = $this->identity['class'];

        $this->session = &$_SESSION;

        if(empty($this->session['identity'])){
            $identity = new \io\web\Identity();
            $identity->identity = new $sessionUser();
            $this->session['identity'] = $identity;
        }

        $this->user = &$this->session['identity'];
    }

    public function run(){
        $this->prepare();

        $this->initialize();

        return $this->parseRequest( $this->handleRequest() );
    }

    public function handleRequest(){
        $url = $this->request->REQUEST_URI;
        if(strpos($url, '?') !== false){
            $url = substr($url, 0, strpos($url, '?'));
        }
        return $url;
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
