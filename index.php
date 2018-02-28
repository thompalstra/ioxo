<html>
    <head>
        <link href="http://www.ioxo.nl/latest/scope/scope.core.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/scope.core.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/widgets/tabs/scope.widgets.tabs.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/widgets/tabs/scope.widgets.tabs.js" type="text/javascript"></script>

        <link href="http://www.ioxo.nl/latest/scope/tools/datalist/scope.tools.datalist.css" rel="stylesheet"/>
        <script src="http://www.ioxo.nl/latest/scope/tools/datalist/scope.tools.datalist.js" type="text/javascript"></script>

        <title>IOXO home</title>
    </head>
    <body>
        <div class='wrapper'>
            <div id='w0-tabs' class='tabs'>
                <ul class="tabcontrols">
                    <li sc-target="#w0-tabs-about-ioxo" class="active">About <strong>IOXO</strong></li>
                    <li sc-target="#w0-tabs-widgets">Widgets</li>
                    <li sc-target="#w0-tabs-tools">Tools</li>
                </ul>
                <ul class="tabcontent">
                    <li id='w0-tabs-about-ioxo' class="active">
                        <h2>About <strong>IOXO</strong></h2>
                    </li>
                    <li id='w0-tabs-widgets'>
                        <h2>Widgets</h2>
                        <ul class='datalist'>
                            <a href="/latest/scope/widgets/tabs/example.html">
                                <li>
                                    Tabs
                                </li>
                            </a>
                            <a href="/latest/scope/widgets/yt-player/example.html">
                                <li>
                                    Youtube player
                                </li>
                            </a>
                        </ul>
                    </li>
                    <li id='w0-tabs-tools'>
                        <h2>Tools</h2>
                        <ul class='datalist'>
                            <a href="/latest/scope/tools/datalist/example.html">
                                <li>
                                    Datalist
                                </li>
                            </a>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <script>
            var w0tabs = new Tabs( document.findOne('#w0-tabs') );
        </script>
    </body>
</html>
