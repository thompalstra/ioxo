<?php
use io\widgets\Form;
use io\helpers\Html;
use io\data\Security;
?>

<div class='element'>
    <div class='inner'>
        <h1>login</h1>

        <?php $form = new Form([
            'template' => '{rowBegin}{label}{input}{error}{rowEnd}',
            'templateOptions' => [
                'rowBegin' => [
                    'class' => 'row row-default'
                ],
                'label' => [
                    'class' => 'label label-default col dt2 tb4 mb12 xs12'
                ],
                'input' => [
                    'class' => 'input input-default col dt10 tb8 mb12 xs12'
                ],
                'error' => [
                    'class' => 'error error-default col dt12 tb12 mb12 xs12',
                ],
            ],
            'options' => [
                'id' => 'form-login-form',
                'class' => 'form form-default',
                'method' => 'POST',
                'action' => '/login'
            ]
        ]); ?>

        <?=$form->field($model, 'username')->textInput(['type' => 'text', 'class' => 'derp'])?>
        <?=$form->field($model, 'password')->passwordInput(['type' => 'password'])?>
        <a href="/" class='btn btn-flat action-flat'>cancel</a>
        <?=Html::button('LOGIN', ['class' => 'btn btn-default action'])?>

    <?php $form->end() ?>

    </div>
</div>
