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

    public function rules(){
        return [];
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

        if( class_exists( $controllerName ) ){

            Scope::$app->controller = new $controllerName([
                'path' => $path,
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
        $controllerName =  str_replace('/', '\\', $controllerNamespaceName . $controllerShortName);

        return new $controllerName([
            'path' => '',
            'controllerId' => Scope::$app->_web->defaultController
        ]);
    }

    public function runAction( $actionId ){
        $this->actionId = $actionId;
        $actionName = 'action' . Html::toCamelCase( $actionId );
        if( method_exists( $this, $actionName ) ){
            if( $this->allowedAction( $actionId ) ){
                return call_user_func_array( [ $this, $actionName ], [] );
            }

        } else {
            $controllerName = $this->className();
            return $this->render( $actionId );
        }
    }
    public function allowedAction( $actionId ){
        foreach( $this->rules() as $rule ){
            $actionIds = $rule[0];
            if( in_array( $actionId, $actionIds ) ){
                if( isset( $rule['deny'] ) && $rule['deny'] == true ){
                    if( isset($rule['onDeny']) ){
                        $fn = $rule['onDeny'];
                        $fn( $actionId, $rule ) ;
                    }
                    return false;
                }
                if( isset( $rule['allow'] ) && $rule['allow'] == true ){
                    if( isset($rule['onAllow']) ){
                        $fn = $rule['onAllow'];
                        $fn( $actionId, $rule ) ;
                    }
                    return true;
                }
            }
        }
        return true;
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

    public function render( $_view, $data = [] ){
        $view = new View();

        $content = $view->renderFile($_view, $data );

        $layoutPath = DIRECTORY_SEPARATOR . Scope::$app->environment->layoutPath . DIRECTORY_SEPARATOR . $this->layout . '.php';

        return $view->renderFile( $layoutPath, [
            'view' => $content
        ] );
    }
    public function renderView( $_view, $data = [] ){
        $view = new View();

        return $view->renderFile($_view, $data );
    }

    public function json( $data ){
        echo json_encode( $data );
        exit();
    }
}
?>
