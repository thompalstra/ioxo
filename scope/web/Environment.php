<?php
namespace scope\web;

use Scope;

class Environment extends \scope\core\Base{
    public static function parse( $host ){
        $environment = new self();
        $parts = explode( '.', $host );

        if( count( $parts ) > 2 ){
            // unsets domain ext
            unset( $parts[ count($parts) -1 ] );
            // unsets domain name
            unset( $parts[ count($parts) -1 ] );
        } else {
            $parts = [Scope::$app->env->default];
        }

        $environment->name = implode('.', $parts);
        if( !in_array( $environment->name, Scope::$app->env->supported ) ){
            $environment->name = Scope::$app->env->default;
        }

        $environment->basePath = Scope::$app->root . $environment->name . DIRECTORY_SEPARATOR;
        $environment->controllerPath = $environment->name . DIRECTORY_SEPARATOR . 'controllers';
        $environment->viewPath = $environment->name . DIRECTORY_SEPARATOR . 'views';
        $environment->layoutPath = $environment->name . DIRECTORY_SEPARATOR . 'layouts';

        return $environment;
    }
}
?>
