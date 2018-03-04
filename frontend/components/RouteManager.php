<?php
namespace frontend\components;

use Scope;
use common\models\scope\cms\Page;

class RouteManager extends \scope\core\Base{
    public static function parse( $route ){

        $query = Scope::query()->from( Page::className() );

        $query->leftJoin( 'scope_cms_translation AS sct ON sct.model_id = scope_cms_page.id' );
        $query->where([
            'and',
            [ 'sct.model_name' => str_replace('\\', '_', Page::className() ) ],
            [ 'sct.attribute' => 'url' ],
            [ 'sct.language' => 'nl' ],
            [ 'sct.value' => "/" . $route[0] ],
            [ 'is_enabled' => 1 ],
            [ 'is_deleted' => 0 ],
        ]);

        $page = $query->one();

        if( $page ){
            Scope::$app->context->page = $page;
            return [ 'scope-cms-page/scope-cms-page-view', $_GET ];
        }

        return $route;
    }
}
?>
