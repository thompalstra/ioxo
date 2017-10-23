<?php
namespace io\web;
use io\helpers\ArrayHelper;
class Auth extends \io\base\Model{
    public static $table = "auth";

    public function attributes(){
        return [
            'page_size'         => \IO::translate('io', 'Page size'),
            'id'                => \IO::translate('io', '#'),
            'search_value'     => \IO::translate('io', 'Search value'),
            'usedRoles'         => \IO::translate('io', 'Used roles'),
            'is_enabled'        => \IO::translate('io', 'Enabled')
        ];
    }

    public static function getDataList(){
        return ArrayHelper::map( self::find()->all(), 'id', 'name');
    }
}
?>
