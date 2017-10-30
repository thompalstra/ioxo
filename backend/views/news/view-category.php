<?php

use io\web\Url;
use io\widgets\Form;
use io\helpers\Html;

use io\widgets\Slidebox;
use common\models\NewsCategory;
use common\models\NewsContent;

?>
<div class='header header-default'>
    <div class='container'>
        <h1 class='title'><?=($model->isNewModel) ? "New item" : "$model->title"?></h1>
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
    <div class='col dt10 tb10 mb12 xs12 inner'>
        <?=$form->field($model, 'title')->textInput([
            'behaviour' => 'active',
            'required' => '',
            'pattern' => ".{4,}",
            'title' => 'Category title must be at least 4 characters.',
        ])?>
        <?=$form->field($model, 'url')->textInput()?>
    </div>
    <div class='row row-btn'>
        <?=Html::button('Save', ['class' => 'btn btn-default action pull-right'])?>
        <a href="/news/index-category" class='btn btn-flat default-flat pull-right'><?=($model->isNewModel) ? 'Discard changes' : 'Cancel'?></a>
    </div>
    <?=$form->end()?>
</div>
