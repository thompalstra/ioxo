<html>
    <head>
    <?=$this->head()?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="/common/web/css/ioxo.core.css">
    <link rel="stylesheet" href="/common/web/css/ioxo.theme.css">
    <link rel="stylesheet" href="/common/web/css/ioxo.forms.css">
    <link rel="stylesheet" href="/common/web/css/ioxo.buttons.css">
    <link rel="stylesheet" href="/common/web/css/ioxo.widgets.css">

    <link rel="stylesheet" href="/backend/web/css/style.css">
    <link rel="stylesheet" href="/common/web/css/back-login.css">
    </head>
<?php
 ?>
    <body class='theme <?=\IO::$app->controller->layout?>'>
        <?=$content?>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="/common/web/js/ioxo.app.js"></script>
        <script src="/common/web/js/ioxo.core.js"></script>
        <script src="/common/web/js/ioxo.forms.js"></script>
        <script src="/common/web/js/ioxo.widgets.js"></script>
        <?=$this->footer()?>
    </body>
</html>
