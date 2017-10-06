<?php
namespace io\web;

class Url{
    public static function to($url, $parameters){
        $q = http_build_query($parameters);
        return $url . (!empty($q) ? '?' . $q : '' );
    }

}
?>
