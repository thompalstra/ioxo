<?php
namespace scope\web;

use Scope;

class Request extends \scope\core\Base{
    public static function parse( $server ){

        $request = new self();

        $request->url = self::parseUrl( $server['REQUEST_URI'] );
        $request->host = strtolower( $server['HTTP_HOST'] );
        $request->subdomain = self::parseSubdomain( $server['HTTP_HOST'] );

        return $request;
    }

    public static function parseUrl( $request_uri ){
        $request_uri = trim( $request_uri, '/' );

        if( ( $pos = strpos( $request_uri, '?' ) ) !== false ){
            $request_uri = substr( $request_uri, 0, $pos );
        }

        return $request_uri;
    }

    public static function parseSubdomain( $httphost ){
        $parts = explode( '.', $httphost );

        if( count( $parts ) > 2 ){
            array_pop( $parts );
            array_pop( $parts );
            return implode( '.', $parts );
        } else {
            return Scope::$app->_environment->default;
        }
    }
}
?>
