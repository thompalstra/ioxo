<html>
    <head>
    <?=$this->head()?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="/common/web/css/ioxo.theme.css">
    <link rel="stylesheet" href="/common/web/css/ioxo.forms.css">
    <link rel="stylesheet" href="/common/web/css/ioxo.buttons.css">
    <link rel="stylesheet" href="/common/web/css/ioxo.core.css">
    </head>
    <body>
        <ul class='menu menu-default'>
            <li class='item pull-left'><i class='icon material-icons'>menu</i></li>
            <?php if(\IO::$app->user->isGuest){ ?>
                <li class='item pull-left'><a href="/login"><span>log in</span></a></li>
            <?php } else { ?>
                <li class='item dropdown pull-left'>
                    <?php
                    ?>
                    <span><?=\IO::$app->user->identity->username?></span>
                    <ul>
                        <a href="/profile"><li class='item'><span>profile</span></li></a>
                        <a href="/logout"><li class='item'><span>log out</span></li></a>
                    </ul>
                </li>
            <?php } ?>
            <li class='item pull-right'><i class="icon material-icons">more_vert</i></li>
        </ul>
        <div class='container'>
            <?=$content?>
        </div>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="/common/web/js/ioxo.core.js"></script>
        <script src="/common/web/js/ioxo.forms.js"></script>
        <?=$this->footer()?>
    </body>
</html>
