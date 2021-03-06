<?php

class Application{

    public $_web = [];
    public $_session = [];
    public $_environment = [];
    public $_db = [];

    public $web;
    public $session;
    public $environment;
    public $db;
    public $root;
    public $context;


    public function __construct( $arg = [] ){
        include( __DIR__ . DIRECTORY_SEPARATOR . 'Scope.php' );
        include( __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php' );

        \Scope::$app = $this;

        foreach( $arg as $k => $v ){
            if( $v === true || $v === false ){
                $this->$k = (bool) $v;
            } else {
                $this->$k = (object) $v;
            }
        }

        $this->root = dirname( __DIR__ ) . DIRECTORY_SEPARATOR;
        $this->context = new \stdClass();

        $this->loadIni( $this->getIni( $this->root . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'conf.ini' ) );

        $this->environment = \scope\web\Environment::parse( $_SERVER['HTTP_HOST'] );

        $this->loadIni( $this->getIni( $this->root . DIRECTORY_SEPARATOR . $this->environment->name . DIRECTORY_SEPARATOR . 'conf.ini' ) );

        $this->web = ( object ) [
            'request' => \scope\web\Request::parse( $_SERVER )
        ];

        if( $this->_db !== false ){
            $this->db = (object) [
                'conn' => new \PDO( $this->_db->dsn, $this->_db->username, $this->_db->password, [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ] )
            ];
        }
    }

    public function getIni( $path ){
        if( file_exists( $path ) ){
            return parse_ini_file( $path, true );
        }
        return [];
    }

    public function loadIni( $ini ){
        foreach( $ini as $k => $v ){
            $this->$k = (object) $v;
        }
    }

    public function run(){

        session_start();
        $this->session = &$_SESSION;

        $identityClass = $this->_session->identity['identityClass'];
        $identityClass::getIdentity();

        if( !isset( $this->session['language'] ) ){
            $this->session['language'] = Scope::$app->_language->default;
        }

        Scope::$app->language = &$_SESSION['language'];

        $routeManagerClass = $this->_web->routeManagerClass;
        $controllerClass = $this->_web->controllerClass;

        $route = $routeManagerClass::parse( [ $this->web->request->url, $_GET ] );

        return $controllerClass::parse( $route );
    }
}
?>
