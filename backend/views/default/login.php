<?php
use io\widgets\Form;
use io\helpers\Html;
use io\data\Security;
?>

<div class='element'>
    <div class='inner'>
        <?php $form = new Form([
            'template' => '{rowBegin}{label}{input}{error}{rowEnd}',
            'templateOptions' => [
                'rowBegin' => [
                    'class' => 'row row-default'
                ],
                'label' => [
                    'class' => 'label label-default col dt1 tb2 mb12 xs12',
                ],
                'input' => [
                    'class' => 'input input-default col dt12 tb12 mb12 xs12'
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

        <?=$form->field($model, 'username')->label(false)->textInput(['type' => 'text'])?>
        <?=$form->field($model, 'password')->label(false)->passwordInput(['type' => 'password'])?>
        <?=$form->errorField($model, 'model')?>
        <div class='row row-btn'>
        <?=Html::button('LOGIN', ['class' => 'btn btn-default action pull-right'])?>
        <a href="/" class='btn btn-flat action-flat pull-right'>cancel</a>
        </div>

    <?php $form->end() ?>

    </div>
</div>
