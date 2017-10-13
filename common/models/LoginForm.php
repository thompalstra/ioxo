<?php
namespace common\models;

class LoginForm extends \common\models\User{
    public function rules(){
        return [
            [['username', 'password'], 'required']
        ];
    }
}
?>
