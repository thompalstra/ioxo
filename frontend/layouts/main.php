<?php
$this->registerAsset(\common\assets\IoAsset::className());
$this->registerAsset(\frontend\assets\FrontAsset::className());
$this->registerAsset(\common\assets\WidgetAsset::className());
?>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?=$this->head()?>
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
            <li class='item dropdown pull-right'>
                <i class="icon material-icons">more_vert</i>
                <ul>
                    <?php if(\IO::$app->user->isGuest) { ?>
                        <a href="/login"><li class='item pull-left' behaviour="active"><span>log in</span></li></a>
                    <?php } else { ?>

                    <?php } ?>
                </ul>
            </li>
        </ul>

        <div id='my-dialog' class='dialog' dialog-ok='Ok' dialog-cancel='Cancel' backdrop>
            <div class='content'>
                <p><strong>Cookies</strong></p>
                <p>To use this website to it's full extend, we need to know if you accept cookies and temporary files to let us store some temporary data</p>
                <p>For example: <br>
                    <ul>
                        <li>When using a search form, some of the search values may be temporarily stored</li>
                    </ul>
                </p>
            </div>
        </div>
        <div class='dialog-backdrop'></div>

        <?=$content?>
        <?=$this->footer()?>
    </body>
</html>
