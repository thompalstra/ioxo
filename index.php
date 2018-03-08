<?php
header('Access-Control-Allow-Origin: *');

include( __DIR__ . DIRECTORY_SEPARATOR . 'scope' . DIRECTORY_SEPARATOR . 'Application.php' );
$app = new Application();
echo $app->run(); exit();
?>
