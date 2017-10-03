<html>
    <head>
    <?=$this->head()?>
    <link rel="stylesheet" href="/common/web/css/ioxo.forms.css">
    <link rel="stylesheet" href="/common/web/css/ioxo.buttons.css">
    <link rel="stylesheet" href="/common/web/css/ioxo.core.css">
    </head>
    <body>
        <ul class='menu menu-default action'>
            <li class='item'>menu</li>
            <?php if(\IO::$app->user->isGuest){ ?>
                <li class='item'><a href="/login">log in</a></li>
            <?php } else { ?>
                <li class='dropdown'>
                    <?php
                    ?>
                    <?=\IO::$app->user->identity->username?>
                    <ul>
                        <a href="/profile"><li class='item'>profile</li></a>
                        <a href="/logout"><li class='item'>log out</li></a>
                    </ul>
                </li>
            <?php } ?>
        </ul>
        <div class='container'>
            <?=$content?>
        </div>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="/common/web/js/core.js"></script>
        <?=$this->footer()?>
    </body>
</html>
