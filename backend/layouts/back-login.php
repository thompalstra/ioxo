<?php
use common\assets\IoAsset;
use backend\assets\BackAsset;
$this->registerAsset(IoAsset::className());
$this->registerAsset(BackAsset::className());
?>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?=$this->head()?>
        <link rel="stylesheet" href="/common/web/css/back-login.css">
    </head>
<?php
 ?>
    <body class='theme <?=\IO::$app->controller->layout?>'>
        <?=$content?>
        <?=$this->footer()?>
    </body>
</html>
