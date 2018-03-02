<?php
namespace scope\web;

use Scope;
use scope\base\Html;

class Controller extends scope\core\Base{
    public function __construct( $arg = [] ){
        foreach( $arg as $k => $v ){
            $this->$k = $v;
        }
        $this->layout = Scope::$app->_web->defaultLayout;
    }
    public static function parse( $route ){
        $path = trim( $route[0], '/' );

        $parts = explode( '/', $path );

        $controllerId = Scope::$app->_web->defaultController;
        $path = '';
        $actionId = Scope::$app->_web->defaultAction;

        if( count($parts) > 0 ){

            if( !empty( $parts[ count($parts) - 1 ] ) ){
                $actionId = $parts[ count($parts) - 1 ];
            }
            array_pop($parts);
        } else {
            $actionId = Scope::$app->_web->defaultAction;
        }

        if( count( $parts ) > 0 ){
            if( !empty( $parts[ count($parts) - 1 ] ) ){
                $controllerId = $parts[ count($parts) - 1 ];
            }
            array_pop($parts);
        }

        if( count( $parts ) > 0 ){
            $path = implode($parts, '/') . DIRECTORY_SEPARATOR;
            $path = str_replace(['-', '_'], ['', ''], $path);
        }

        $environmentName = Scope::$app->environment->name;

        $controllerShortName = Html::toCamelCase( $controllerId ) . 'Controller';

        $controllerNamespaceName = Scope::$app->environment->controllerPath . DIRECTORY_SEPARATOR . $path;
        $controllerName =  str_replace('/', '\\', $controllerNamespaceName . $controllerShortName);

        // var_dump($actionId); die;

        if( class_exists( $controllerName ) ){

            Scope::$app->controller = new $controllerName([
                'controllerId' => $controllerId
            ]);
            return Scope::$app->controller->runAction( $actionId );

        } else {
            Scope::$app->controller = Controller::getDefaultController();
            return Scope::$app->controller->runError( "Page not found" );
        }
    }

    public static function getDefaultController(){
        $environmentName = Scope::$app->environment->name;

        $controllerShortName = Html::toCamelCase( Scope::$app->_web->defaultController ) . 'Controller';
        $controllerNamespaceName = Scope::$app->environment->controllerPath . DIRECTORY_SEPARATOR . '';
        $controllerName = $controllerNamespaceName . $controllerShortName;
        return new $controllerName([
            'controllerId' => Scope::$app->_web->defaultController
        ]);
    }

    public function runAction( $actionId ){
        $this->actionId = $actionId;
        $actionName = 'action' . Html::toCamelCase( $actionId );
        if( method_exists( $this, $actionName ) ){
            return call_user_func_array( [ $this, $actionName ], [] );
        } else {
            $controllerName = $this->className();
            return $this->render( $actionId );
        }
    }

    public function runError( $message ){
        $exception = new \Exception($message, 404);

        $actionName = 'action' . Html::toCamelCase( Scope::$app->_web->defaultError );
        if( method_exists( $this, $actionName ) ){
            return call_user_func_array( [ $this, $actionName ], [ $exception ] );
        } else {
            Scope::$app->controller = Controller::getDefaultController();
            if( method_exists( Scope::$app->controller, $actionName ) ){
                return call_user_func_array( [ Scope::$app->controller, $actionName ], [ $exception ] );
            } else {
                echo 'missing default actionError'; die;
            }
        }
    }

    public function render( $view, $data = [] ){
        $layoutPath = DIRECTORY_SEPARATOR . Scope::$app->environment->layoutPath . DIRECTORY_SEPARATOR . $this->layout . '.php';
        return View::renderFile( $layoutPath, [
            'view' => View::renderFile($view, $data )
        ] );
    }
}
?>
