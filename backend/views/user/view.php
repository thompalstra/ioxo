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
<?=$form->field($model, 'username')->textInput()?>
<?=$form->field($model, 'is_enabled')->widget(Slidebox::className(), [
    'inputOptions' => [
        'class' => 'dsa',
    ],
    'options' => [
        'allowIndeterminate' => true,
    ],
])?>
