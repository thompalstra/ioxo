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
    </head>
    <body class='theme <?=\IO::$app->controller->theme?>'>
        <ul class='menu menu-default'>
            <li class='item dropdown pull-left'>
                <i class='icon material-icons'>menu</i>
                <ul>
                    <?php if(\IO::$app->user->isGuest) { ?>
                    <?php } else { ?>
                        <a href="/user/index"><li class='item' behaviour="active"><span><i class="material-icons icon pull-left">&#xE853;</i> User</span></li></a>
                        <a href="/auth/index"><li class='item' behaviour="active"><span><i class="material-icons icon pull-left">&#xE898;</i> Auth</span></li></a>
                        <a href="/translate/index"><li class='item' behaviour="active"><span><i class="material-icons icon pull-left">&#xE8E2;</i> Translate</span></li></a>
                    <?php } ?>
                </ul>
            </li>
            <li class='item dropdown pull-right'>
                <i class="icon material-icons">more_vert</i>
                <ul>
                    <?php if(\IO::$app->user->isGuest) { ?>
                        <a href="/login"><li class='item pull-left' behaviour="active"><span>log in</span></li></a>
                    <?php } else { ?>
                        <a href="/profile"><li class='item' behaviour="active"><span>profile</span></li></a>
                        <a href="/logout"><li class='item' behaviour="active"><span>log out</span></li></a>
                    <?php } ?>
                </ul>
            </li>
        </ul>
        <?=$content?>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="/common/web/js/ioxo.core.js"></script>
        <script src="/common/web/js/ioxo.forms.js"></script>
        <script src="/common/web/js/ioxo.widgets.js"></script>
        <?=$this->footer()?>
    </body>
</html>
