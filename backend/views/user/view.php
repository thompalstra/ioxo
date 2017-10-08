<?php
use io\widgets\Form;
use io\helpers\Html;

use io\widgets\Slidebox;
?>

<?php $form = new Form([
    'template' => '{rowBegin}{label}{input}{error}{rowEnd}',
    'templateOptions' => [
        'rowBegin' => [
            'class' => 'row row-default'
        ],
        'label' => [
            'class' => 'label label-default default-flat col dt4 tb2 mb12 xs12',
        ],
        'input' => [
            'class' => 'input input-default col dt8 tb12 mb12 xs12'
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
<?=$form->field($model, 'username')->textInput(['behaviour' => 'active'])?>
<?=$form->field($model, 'is_enabled')->label(false)->widget(Slidebox::className(), [
    'inputOptions' => [
        'class' => 'dsa',
        'behaviour' => 'active'
    ],
])?>
<?=$form->field($model, 'new_password')->passwordInput(['behaviour' => 'active'])?>
<?=$form->field($model, 'new_password_repeat')->passwordInput(['behaviour' => 'active'])?>

<div class='row row-btn'>

    <?=Html::button('Save', ['class' => 'btn btn-default action pull-right'])?>
    <a href="/user/index" class='btn btn-flat default-flat pull-right'><?=($model->isNewModel) ? 'Cancel' : 'Discard changes'?></a>
</div>

<?php $form->end() ?>
