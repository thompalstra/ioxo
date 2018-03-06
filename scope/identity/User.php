<?php
namespace scope\identity;

use Scope;

class User extends \scope\identity\Identity{
    public $id;
    public $username;

    public static function tableName(){
        return "user";
    }
}
?>
