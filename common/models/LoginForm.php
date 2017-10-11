<?php
namespace common\models;

class LoginForm extends \io\web\User{
    public function rules(){
        return [
            [['username', 'password'], 'required']
        ];
    }
}
?>
