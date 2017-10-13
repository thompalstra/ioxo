<?php
use io\widgets\Form;
use io\helpers\Html;

use io\widgets\Slidebox;

?>
<div class='header header-default'>
    <div class='container'>
        <h1 class='title'><?=$model->source_message?></h1>
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
    <div class='col dt12 tb12 mb12 xs12 inner'>
        <?=$form->field($model, 'source_message')->textInput([
            'behaviour' => 'active',
            'required' => ''
        ])?>
        <?php foreach(\IO::$app->languages as $language){ ?>
            <div class='row row-default'>
                <label class="label label-default default-flat col dt1 tb1 mb12 xs12"><?=$language?></label>
                <?=Html::textInput(
                    "Translate[messages][$language]",
                    \IO::translate($model->category, $model->source_message, $language),
                    [
                        'class' => 'input input-default col dt11 tb11 mb12 xs12',
                        'required' => ''
                    ]
                )?>
            </div>
        <?php } ?>
    </div>
    <div class='row row-btn'>
        <?=Html::button('Save', ['class' => 'btn btn-default action pull-right'])?>
        <a href="/translate/index" class='btn btn-flat default-flat pull-right'><?=($model->isNewModel) ? 'Discard changes' : 'Cancel'?></a>
    </div>
    <?=$form->end()?>
</div>
