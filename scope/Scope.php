<?php
class Scope{
    public static $app;
    public static function query(){
        return new \scope\db\Query();
    }
}
?>
