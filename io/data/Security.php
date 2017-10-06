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
        $session = &\IO::$app->session;

        if(!isset($session['_csrf'])){
            $csrf = new \stdClass();
            $csrf->token = self::getCsrfToken();
            $csrf->timeout = self::getCsrfTimeout();

            $session['_csrf'] = $csrf;
        } else {
            $csrf = $session['_csrf'];
            $timeout = $csrf->timeout;
            $current = time() - \IO::$app->csrfTimeout;

            $diff = $current - $timeout;

            if($diff > \IO::$app->csrfTimeout){
                $csrf = new \stdClass();
                $csrf->token = self::getCsrfToken();
                $csrf->timeout = self::getCsrfTimeout();
                $session['_csrf'] = $csrf;
            }
        }

        return $session['_csrf'];
    }

    public static function validateCsrf($token){
        // check if csrf is still valid
        $csrf = \IO::$app->_csrf;
        return hash_equals($csrf->token, $token);
    }

    public static function getCsrfToken($length = 32){
        if (function_exists('random_bytes')) {
            $result = bin2hex(random_bytes($length));
        } else if (function_exists('mcrypt_create_iv')) {
            $result = bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        } else if (function_exists('openssl_random_pseudo_bytes')) {
            $result = bin2hex(openssl_random_pseudo_bytes($length));
        }

        return $result;
    }
    public static function getCsrfTimeout(){
        return time() + \IO::$app->csrfTimeout;
    }
}

?>
