<?php
namespace io\data;

class Security{
    public static function passwordVerify($password, $hash){
        return password_verify ( $password, $hash );
    }

    public static function passwordHash($password){
        return password_hash ( $password, PASSWORD_DEFAULT );
    }
}

?>
