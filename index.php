<?php
include( __DIR__ . DIRECTORY_SEPARATOR . 'scope' . DIRECTORY_SEPARATOR . 'Application.php' );
$app = new Application([
    '_web' => [
        'controllerClass' => '\scope\web\Controller',
        'routeManagerClass' => '\scope\web\RouteManager',
        'defaultAction' => 'index',
        'defaultController' => 'default',
        'defaultError' => 'error',
        'defaultLayout' => 'main'
    ],
    '_session' => [
        'identity' => [
            'identityClass' => '\scope\identity\User'
        ]
    ],
    '_environment' => [
        'default' => 'frontend',
        'supported' => [
            'frontend', 'backend'
        ]
    ],
    '_db' => [
        'dsn' => 'mysql:dbname=sample_db;host=127.0.0.1',
        'username' => 'root',
        'password' => '',
        'options' => []
    ]
]);
echo $app->run(); exit();
?>
