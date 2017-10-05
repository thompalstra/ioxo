<?php
namespace io\data;

class Security{
    public static function passwordVerify($password, $hash){
        return password_verify ( $password, $hash );
    }

    public static function passwordHash($password){
        return password_hash ( $password, PASSWORD_DEFAULT );
    }

    public static function getCsrf(){
        $session = \IO::$app->session;

        if(!isset($session['_csrf'])){
            $csrf = new \stdClass();
            $csrf->token = self::getCsrfToken();
            $csrf->timeout = self::getCsrfTimeout();

            $session['_csrf'] = $csrf;
        }

        return $session['_csrf'];
    }

    public static function getCsrfToken(){
        return 2;
    }
    public static function getCsrfTimeout(){
        return 60 * 60;
    }
}

?>
