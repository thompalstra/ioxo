<?php
use io\widgets\Form;
use io\helpers\Html;

use io\widgets\Slidebox;
?>
<div class='header header-default theme user'>
    <div class='container'>
        <h1 class='title'><?=($model->isNewModel) ? "New account" : "$model->username's account"?></h1>
    </div>
</div>
<div class='container'>
    <?php $form = new Form([
        'template' => '{rowBegin}{label}{input}{error}{rowEnd}',
        'templateOptions' => [
            'rowBegin' => [
                'class' => 'row row-default'
            ],
            'label' => [
                'class' => 'label label-default default-flat col dt12 tb12 mb12 xs12',
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
        ]
    ]); ?>
    <?=$form->begin()?>
    <div class='col dt6 tb6 mb12 xs12 inner'>
        <?=$form->field($model, 'username')->textInput([
            'behaviour' => 'active',
            'required' => '',
            'pattern' => ".{6,24}",
            'title' => 'Username must be between 6 and 24 characters long',
        ])?>
        <?=$form->field($model, 'email')->input([
            'behaviour' => 'active',
            'required' => '',
            "type" => "email"
        ])?>
        <?=$form->field($model, 'is_enabled')->widget(Slidebox::className(), [
            'inputOptions' => [
                'behaviour' => 'active'
            ],
        ])?>
        <?=$form->field($model, 'usedRoles[]')->select($model->roles, ['multiple' => true])?>
    </div>
    <div class='col dt6 tb6 mb12 xs12 inner'>
        <?=$form->field($model, 'new_password')->passwordInput(['behaviour' => 'active'])?>
        <?=$form->field($model, 'new_password_repeat')->label(false)->passwordInput(['behaviour' => 'active'])?>
    </div>
    <div class='row row-btn'>
        <?=Html::button('Save', ['class' => 'btn btn-default action pull-right'])?>
        <a href="/user/index" class='btn btn-flat default-flat pull-right'><?=($model->isNewModel) ? 'Discard changes' : 'Cancel'?></a>
    </div>
    <?=$form->end()?>
</div>
