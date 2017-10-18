<?php

use io\web\Url;
use io\widgets\Form;
use io\helpers\Html;

use io\widgets\Slidebox;

?>
<div class='header header-default theme user'>
    <div class='container'>
        <h1 class='title'><?=($model->isNewModel) ? "New news items" : "$model->title"?></h1>
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
            'title' => 'News title must be at least 4 characters.',
        ])?>
        <?=$form->field($model, 'url')->textInput()?>
    </div>
    <div class='col dt2 tb2 mb12 xs12 inner'>
        <?=$form->field($model, 'is_enabled')->widget(Slidebox::className(), [
            'inputOptions' => [
                'behaviour' => 'active'
            ],
        ])?>
    </div>
    <div class='col dt6 tb6 mb12 xs12 inner'>
        <div class='row row-btn'>
            <?=Html::a('<i class="material-icons icon pull-left">&#xE145;</i> NEW CONTENT', Url::to('/news/view-item'), ['id' => 'add-news-content', 'class' => 'btn btn-icon btn-default success pull-right'] )?>

            <button class="item dropdown pull-left">
                <i class="icon material-icons">menu</i>
                <ul>
                    <li class='item add-news-content' type='1'>Regular</li>
                    <li class='item add-news-content' type='2'>Code</li>
                    <li class='item add-news-content' type='3'>Quote</li>
                </ul>
            </button>
        </div>
        <div id='news-content-collection'>
            <div id='news-content-collection-inner'>
            <?php foreach($model->content as $k => $v) { ?>
                <div class='row'>
                <?=Html::textarea(
                    "NewsItem[content_old][$k]",
                    $v,
                    [
                        'class' => 'input input-default col dt12 tb12 mb12 xs12',
                        'behaviour' => 'active',
                        'rows' => 5
                    ]
                )?>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>
    <div class='col dt6 tb6 mb12 xs12 inner'></div>
    <div class='row row-btn'>
        <?=Html::button('Save', ['class' => 'btn btn-default action pull-right'])?>
        <a href="/user/index" class='btn btn-flat default-flat pull-right'><?=($model->isNewModel) ? 'Discard changes' : 'Cancel'?></a>
    </div>
    <?=$form->end()?>
</div>


<?php
$js = <<<JS
_(document).when('click', '.add-news-content', function(e){
    e.preventDefault();
    var type = $(this).attr('type');
    $.ajax({
        url: '/news/new-content',
        method: 'POST',
        data: {
            'news_item_id': "$model->id",
            'type': type
        },
        success: function(resp){
            $('#news-content-collection').load( location.href + " #news-content-collection-inner" );
        }
    })
});
JS;
$this->registerJs($js);

?>
