<html>
    <head>
        <link href="http://www.ioxo.nl/latest/scope/scope.core.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/scope.core.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/widgets/tabs/scope.widgets.tabs.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/widgets/tabs/scope.widgets.tabs.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/tools/datalist/scope.tools.datalist.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/tools/datalist/scope.tools.datalist.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/widgets/datatable/scope.widgets.datatable.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/widgets/datatable/scope.widgets.datatable.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/widgets/form/scope.widgets.form.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/widgets/form/scope.widgets.form.js" type="text/javascript"></script>

        <script src="http://www.ioxo.nl/latest/scope/widgets/cjax/scope.widgets.cjax.js" type="text/javascript"></script>


        <link href="http://www.ioxo.nl/latest/scope/nav/sidebar/scope.nav.sidebar.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/nav/sidebar/scope.nav.sidebar.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/nav/menu/scope.nav.menu.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/nav/menu/scope.nav.menu.js" type="text/javascript"></script>

        <script src="/web/js/script.js" type="text/javascript"></script>
        <script src="/common/web/js/script.js" type="text/javascript"></script>

        <title><?=$this->title?></title>
    </head>
    <body>
        <div class='wrapper'>
            <?php if( Scope::$app->identity->isGuest ) { ?>
                <ul>
                    <a href="/login">
                        <li>
                            Login
                        </li>
                    </a>
                </ul>
            <?php } else { ?>
                <sc-widget id='nav-menu-1' data-widget="Scope.nav.Menu" class="nav-menu">
                    <ul>
                        <li is-dropdown sc-icon-after>
                            CMS
                            <ul>
                                <a href="/cms/pages">
                                    <li >
                                        Pages
                                    </li>
                                </a>
                            </ul>
                        </li>
                        <a href="">
                            <li>
                                Logout
                            </li>
                        </a>
                    </ul>
                </sc-widget>
            <?php } ?>
        </div>
        <?=$view?>
    </body>
</html>
