<?php
namespace io\web;
class Auth extends \io\base\Model{
    public static $table = "auth";

    public function attributes(){
        return [
            'page_size'         => \IO::translate('io', 'Pagesize'),
            'id'                => \IO::translate('io', '#'),
            'search_values'     => \IO::translate('io', 'Search values'),
            'usedRoles'         => \IO::translate('io', 'UsedRoles'),
            'is_enabled'        => \IO::translate('io', 'Enabled')
        ];
    }
}
?>
