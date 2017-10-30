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
                        <a href="/news/index-item"><li class='item' behaviour="active"><span><i class="material-icons icon pull-left">&#xE2C7;</i> News category</span></li></a>
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
        <?php ?>

        <?=$content;?>

        <?php if(\IO::$app->hasFlash()){ ?>
            <span id='flash-box' class='messagebox top-left hidden' io-hidetimeout='1000' io-title='title' io-message='<?=IO::$app->getFlash()?>' io-yes='ok' io-no='no'></span>
<?php
$js = <<<JS
    var element =  _('#flash-box');
    var messagebox = element.messagebox();
    messagebox.show();
JS;
$this->registerJs($js);
?>
        <?php } ?>

        <?=$this->footer();?>

        <?php ?>
    </body>
</html>
