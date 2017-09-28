<?php
use \io\web\User;

$user = User::find()->where([
    '=' => [
        'username' => 'BROTHOM2'
    ],
])->orWhere([
    '!=' => [
        'is_enabled' => 0
    ],
])->andWhere([
    '=' => [
        'is_deleted' => 1,
    ],
])->one();


if($user){
    var_dump($user);
    $user->is_deleted = 1;
    $user->save();

    echo '<pre>';
    var_dump($user->getErrors());
    echo '</pre>';
}




?>

<div class='element'>
    <div class='inner'>
        index
    </div>
</div>
<div class='element col xs6'>
    <div class='inner'>
        index
    </div>
</div>
<div class='element col xs6'>
    <div class='inner'>
        index
    </div>
</div>
