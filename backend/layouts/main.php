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

        <script src="/web/js/script.js" type="text/javascript"></script>
        <script src="/common/web/js/script.js" type="text/javascript"></script>

        <title><?=$this->title?></title>
    </head>
    <body>
        <?php if( Scope::$app->identity->isGuest ) { ?>
            <ul>
                <a href="/login">
                    <li>
                        Login
                    </li>
                </a>
            </ul>
        <?php } else { ?>
            <ul>
                <a href="/cms/pages">
                    <li>
                        Pages
                    </li>
                </a>
                <a href="/logout">
                    <li>
                        Logout
                    </li>
                </a>
            </ul>
        <?php } ?>
        <?=$view?>
    </body>
</html>
