<?php
include(__DIR__ . DIRECTORY_SEPARATOR . 'io' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'Application.php');
$app = new \io\system\Application();
return $app->run();
?>
