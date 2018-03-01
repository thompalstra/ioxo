<?php

class Application{
    public function __construct( $arg = [] ){
        include( __DIR__ . DIRECTORY_SEPARATOR . 'Scope.php' );
        include( __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php' );

        \Scope::$app = $this;

        foreach( $arg as $k => $v ){
            $this->$k = $v;
        }

        $this->web = (object) $this->web;
        $this->env = (object) $this->env;
        $this->root = dirname( __DIR__ ) . DIRECTORY_SEPARATOR;

        $this->environment = \scope\web\Environment::parse( $_SERVER['HTTP_HOST'] );
    }
    public function run(){
        $route = [ $_SERVER['REQUEST_URI'], $_GET ];

        $routeManagerClass = \Scope::$app->web->routeManagerClass;
        $controllerClass = \Scope::$app->web->controllerClass;

        return $controllerClass::parse( $routeManagerClass::parse( $route ) );
    }
}
?>
