<?php

namespace common\assets;

class IoAsset extends \io\base\Asset{
    public $css = [

        "https://fonts.googleapis.com/icon?family=Material+Icons",
        "https://fonts.googleapis.com/css?family=Poppins",

        "/common/web/css/ioxo.core.css",
        "/common/web/css/ioxo.theme.css",
        "/common/web/css/ioxo.forms.css",
        "/common/web/css/ioxo.buttons.css",
        "/common/web/css/ioxo.widgets.css"
    ];
    public $js = [
        "http://code.jquery.com/jquery-latest.js",
        "/common/web/js/ioxo.app.js",
        "/common/web/js/ioxo.widgets.js"
    ];
}
?>
