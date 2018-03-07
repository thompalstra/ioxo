<?php
namespace common\models;

use Scope;

use scope\identity\User;

class LoginForm extends User{

    public $username;
    public $password;
    public $user = null;

    public function attributes(){
        return [
            [ ['username', 'password'], 'as' => 'required' ],
            [ ['username'], 'as' => 'string', 'minLength' => 5, 'maxLength' => 25 ],
            [ ['username'], 'as' => 'string', 'minLength' => 5 ],
            [ ['username'], 'as' => 'validateCredentials']
        ];
    }

    public function validateCredentials(){
        if( !$this->hasErrors() ){
            $query = Scope::query()->from( User::className() );
            $query->where([
                'and',
                ['username' => $this->username]
            ]);

            if( ( $dbUser = $query->one() ) ){
                if( password_verify( $this->password, $dbUser->password ) ){
                    $this->user = $dbUser;
                    return true;
                } else {
                    $this->addError('Incorrect credentials.');
                }
            } else {
                $this->addError('No user found matching these credentials.');
            }
        } else {
            $this->addError('No user found matching these credentials.');
        }

        return false;
    }
}
?>
