<?php
namespace scope\identity;

interface IdentityInterface{
    public static function getIdentity();
    public static function setIdentity( $user );
    public function login( $user );
}
?>
