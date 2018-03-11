<?php

 ?>

<html>
    <head>
        <link href="http://www.ioxo.nl/latest/scope/scope.core.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/scope.core.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/widgets/cjax/scope.widgets.cjax.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/widgets/cjax/scope.widgets.cjax.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/widgets/tabs/scope.widgets.tabs.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/widgets/tabs/scope.widgets.tabs.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/widgets/dialog/scope.widgets.dialog.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/widgets/dialog/scope.widgets.dialog.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/widgets/form/scope.widgets.form.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/widgets/form/scope.widgets.form.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/nav/scope.nav.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/nav/scope.nav.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/tools/scope.tools.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/tools/scope.tools.js" type="text/javascript"></script>

        <script src="/web/js/script.js" type="text/javascript"></script>
        <script src="/common/web/js/script.js" type="text/javascript"></script>

        <link href="/web/css/style.css" rel="stylesheet"/>
        <link href="/common/web/css/style.css" rel="stylesheet"/>

        <title><?=$this->title?></title>
    </head>
    <body>
        <div class='wrapper'>
            <sc-widget id='nav-menu-1' data-widget="Scope.nav.Menu" class="nav-menu">
                <ul>
                    <a href="/">
                        <li>
                            Home
                        </li>
                    </a>
                    <li is-dropdown sc-icon-after>
                        Documentation
                        <ul>
                            <a href="/scope-js">
                                <li >
                                    Scope JS
                                </li>
                            </a>
                            <a href="/scope-php">
                                <li>
                                    Scope PHP
                                </li>
                            </a>
                        </ul>
                    </li>
                    <a href="" class='pull-right'>
                        <li>
                            Support us
                        </li>
                    </a>
                    <a href="">
                        <li>
                            About
                        </li>
                    </a>
                </ul>
            </sc-widget>
        </div>
        <?=$view?>
        <!-- <div class='wrapper'>
            <div class='nav'>
                <span class='brand large'>
                    <span>I</span>
                    <span>O</span>
                    <span>X</span>
                    <span>O</span>
                </span>
            </div>
        </div>
        <div class='wrapper'>
            <div class='footer'>
                <span class='brand'>
                    <span>I</span>
                    <span>O</span>
                    <span>X</span>
                    <span>O</span>
                </span> connecting with love
            </div>
        </div> -->
    </body>
</html>
