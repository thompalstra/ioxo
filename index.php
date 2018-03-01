<?php
include( __DIR__ . DIRECTORY_SEPARATOR . 'scope' . DIRECTORY_SEPARATOR . 'Application.php' );
$app = new Application([
    'web' => [
        'controllerClass' => '\scope\web\Controller',
        'routeManagerClass' => '\scope\web\RouteManager',
        'defaultAction' => 'index',
        'defaultController' => 'default',
        'defaultError' => 'error',
        'defaultLayout' => 'main'
    ],
    'env' => [
        'default' => 'frontend',
        'supported' => [
            'frontend', 'backend'
        ]
    ]
]);
echo $app->run(); exit();
?>
