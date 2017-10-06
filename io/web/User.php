<?php
namespace io\web;

use io\web\AuthUser;
use io\web\User;

class User extends \io\base\Model implements \io\web\IdentityInterface{
    public static $table = "user";

    public function rules(){
        return [
            [['username', 'password'], 'required'],
            [['username'], 'number'],
            [['is_deleted'], 'tinyint', 'default' => 0],
            [['is_enabled'], 'tinyint', 'default' => 1]
        ];
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
