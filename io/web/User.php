<?php
namespace io\web;

class User extends \io\base\Model{
    public static $table = "user";


    public function rules(){
        return [
            [['username', 'password'], 'required'],
            [['is_deleted'], 'tinyint', 'default' => 0],
            [['is_enabled'], 'tinyint', 'default' => 1]
        ];
    }
}
?>
