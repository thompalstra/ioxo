<?php
use io\widgets\Form;
use io\helpers\Html;
use io\data\Security;
?>

<div class='element'>
    <div class='inner'>
        <div class='col dt4 tb4 mb12 xs12'></div>
        <div class='col dt4 tb4 mb12 xs12'>
            <h1>Sign in</h1>
            <?php $form = new Form([
                'template' => '{rowBegin}{label}{input}{error}{rowEnd}',
                'templateOptions' => [
                    'rowBegin' => [
                        'class' => 'row row-default'
                    ],
                    'label' => [
                        'class' => 'label label-default col dt4 tb4 mb12 xs12',
                    ],
                    'input' => [
                        'class' => 'input input-default col dt8 tb8 mb12 xs12'
                    ],
                    'error' => [
                        'class' => 'label label-default pull-right error-flat',
                    ],
                ],
                'options' => [
                    'id' => 'form-login-form',
                    'class' => 'form form-default',
                    'method' => 'POST',
                    'action' => '/login'
                ]
            ]); ?>
            <?=$form->begin()?>
            <?=$form->field($model, 'username')->textInput(['type' => 'text'])?>
            <?=$form->field($model, 'password')->passwordInput(['type' => 'password'])?>
            <?=$form->errorField($model, 'model')?>
            <div class='row row-btn'>
            <?=Html::button('LOGIN', ['class' => 'btn btn-default action pull-right'])?>
            <a href="/" class='btn btn-flat action-flat pull-right'>cancel</a>
            </div>
            <?php $form->end() ?>
        </div>
        <div class='col dt4 tb4 mb12 xs12'></div>
    </div>
</div>
