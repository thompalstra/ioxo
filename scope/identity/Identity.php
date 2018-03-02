<?php
namespace scope\identity;

use Scope;

class Identity extends \scope\base\Model implements \scope\identity\IdentityInterface{

    public $user;

    public static function getIdentity(){
        if( !isset( $_SESSION['identity'] ) ){
            $_SESSION['identity'] = [
                'user' => null,
                'isGuest' => true
            ];
        }

        Scope::$app->identity = new self();
        Scope::$app->identity->user = &$_SESSION['identity']['user'];
        Scope::$app->identity->isGuest = &$_SESSION['identity']['isGuest'];
    }

    public static function setIdentity( $user ){
        Scope::$app->identity->user = $user;
    }

    public function login( $user ){
        Scope::$app->identity->user = $user;
        Scope::$app->identity->isGuest = false;
    }

    public function logout(){
        Scope::$app->identity->user = null;
        Scope::$app->identity->isGuest = true;
    }
}
?>
