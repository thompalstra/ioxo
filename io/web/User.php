<?php
namespace io\web;

use io\web\AuthUser;
use io\web\User;

use io\data\Security;

class User extends \io\base\Model implements \io\web\IdentityInterface{
    public static $table = "user";

    public $new_password;
    public $new_password_repeat;

    public function events(){
        return [
            [['\io\events\beforeDeleteEvent'],'beforeDelete'],
            [['\io\events\onUpdateEvent'],'onUpdate'],
        ];
    }

    public function password($model, $attribute, $rule){
        preg_match_all("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/", $model->$attribute, $output_array);
        if(isset($output_array[0]) && isset($output_array[0][0])){

        } else {
            $this->addError($attribute, 'Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters');
        }
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
    public function getRoles(){
        return [''=>'None'] + \io\helpers\ArrayHelper::map(Auth::find()->all(), 'id', 'name');
    }
    public function getUsedRoles(){
        return \io\helpers\ArrayHelper::map(AuthUser::find()->where([
            '=' => [
                'user_id' => $this->id
            ],
        ])->all(), 'auth_id', 'auth_id');
    }

    public function saveRoles(){
        $result = AuthUser::deleteAll([
            '=' => [
                'user_id' => $this->id
            ],
        ]);
        foreach($this->usedRoles as $k => $v){
            if(empty($v)){ continue; }
            $authUser = new AuthUser();
            $authUser->user_id = $this->id;
            $authUser->auth_id = $v;
            $authUser->save();
        }

        return true;
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
