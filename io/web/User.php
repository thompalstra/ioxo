<?php
namespace io\web;

use io\web\AuthUser;
use io\web\User;

use io\data\Security;

class User extends \io\base\Model implements \io\web\IdentityInterface{
    public static $table = "user";

    public $new_password;
    public $new_password_repeat;

    public function rules(){
        return [
            [['new_password'], 'passwordCreate', 'min' => 6, 'max' => 24],
            [['username', 'password'], 'required'],
            [['username'], 'number'],
            [['is_deleted'], 'tinyint', 'default' => 0],
            [['is_enabled'], 'tinyint', 'default' => 1],

        ];
    }

    public function passwordCreate($model, $attribute, $rule){
        if(!empty($this->new_password)){
            if(empty($this->new_password_repeat)){
                $attributeLabel = $model->getAttributeLabel('new_password_repeat');
                $this->addError('new_password_repeat', "$attributeLabel cannot be empty");
            } else {
                $new = $this->new_password;
                $repeat = $this->new_password_repeat;

                if($new !== $repeat){
                    $attributeLabel = $model->getAttributeLabel('new_password');
                    $this->addError('new_password', "Passwords do no match");
                    $attributeLabel = $model->getAttributeLabel('new_password_repeat');
                    $this->addError('new_password_repeat', "Passwords do no match");
                } else {
                    if(strlen($new) < $rule['min']){
                        $min = $rule['min'];

                        $attributeLabel = $model->getAttributeLabel('new_password');
                        $this->addError('new_password', "$attributeLabel must be shorter than $min characters");
                        $attributeLabel = $model->getAttributeLabel('new_password_repeat');
                        $this->addError('new_password_repeat', "$attributeLabel must be shorter than $min characters");

                    } else if(strlen($new) > $rule['max']){
                        $max = $rule['max'];

                        $attributeLabel = $model->getAttributeLabel('new_password');
                        $this->addError('new_password', "$attributeLabel must be shorter than $max characters");
                        $attributeLabel = $model->getAttributeLabel('new_password_repeat');
                        $this->addError('new_password_repeat', "$attributeLabel must be shorter than $max characters");
                    } else {
                        $this->password = Security::passwordHash( $this->new_password );
                    }
                }
            }
        } else {
            if($this->isNewModel && empty($this->password)){
                $attributeLabel = $model->getAttributeLabel('new_password');
                $this->addError('new_password', "$attributeLabel cannot be empty");
                $attributeLabel = $model->getAttributeLabel('new_password_repeat');
                $this->addError('new_password_repeat', "$attributeLabel cannot be empty");
            }
        }
    }

    public function login($model){

        $identity = new \io\web\Identity;
        $identity->isGuest = false;
        $identity->identity = $model;

        \IO::$app->session['identity'] = $identity;

        return true;
    }
    public function logout(){

        unset(\IO::$app->session['identity']);

        return true;
    }

    public function can($role){
        switch($role){
            case '*':
            return true;
            break;
            case '?':
                return (\IO::$app->user->isGuest);
            break;
            default:
                return Auth::find()
                ->leftJoin('auth_user as au', [
                    'au.auth_id' => 'auth.id'
                ])
                ->where([
                    '=' => [
                        'au.user_id' => $this->id,
                        'name' => $role
                    ]
                ])->exists();
            break;
        }
    }
}
?>
