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
            'title' => 'News title must be at least 4 characters.',
        ])?>
        <?=$form->field($model, 'url')->textInput()?>
        <div class='row row-default'>
        <?=Html::select(
            'NewsItem[news_category_id]',
            $model->news_category_id,
            NewsCategory::getDataList(true),
            [
                'class' => 'input input-default',
                'style' => [
                    'width' => 'calc( 100% - 50px )'
                ]
            ])?>
        <a href="/news/view-category" class='btn btn-default btn-only-icon success pull-right'><i class="icon material-icons">&#xE145;</i></a>
        </div>
    </div>
    <div class='col dt2 tb2 mb12 xs12 inner'>
        <?=$form->field($model, 'is_enabled')->widget(Slidebox::className(), [
            'inputOptions' => [
                'behaviour' => 'active'
            ],
        ])?>
    </div>
    <?php if(!$model->isNewModel) : ?>
    <div class='col dt12 tb12 mb12 xs12 inner'>
        <div class='row row-btn'>
            <span class="dropdown btn btn-default btn-icon success pull-left">
                <i class="icon material-icons">menu</i> NEW CONTENT
                <ul>
                    <li class='item' io-method='addNewsContent' io-method-params='datakey=<?=$model->id?>;type=1' behaviour='active'><span>Regular</span></li>
                    <li class='item' io-method='addNewsContent' io-method-params='datakey=<?=$model->id?>;type=2' behaviour='active'><span>Code</span></li>
                    <li class='item' io-method='addNewsContent' io-method-params='datakey=<?=$model->id?>;type=3' behaviour='active'><span>Quote</span></li>
                    <li class='item' io-method='addNewsContent' io-method-params='datakey=<?=$model->id?>;type=4' behaviour='active'><span>Title</span></li>
                    <li class='item' io-method='addNewsContent' io-method-params='datakey=<?=$model->id?>;type=5' behaviour='active'><span>Subtitle</span></li>
                </ul>
            </span>
        </div>
        <div id='newsitem-content_old' class='html-edit' style=''>
            <div id='newsitem-content_old-inner' class='html-edit-inner'>
                <?php foreach($model->content->all() as $content){ ?>
                        <div class='row'>
                            <?=Html::textarea("NewsItem[content_old][$content->id]",$content->content,[
                                    'class' => 'hidden input input-default col dt12 tb12 mb12 xs12',
                                    'behaviour' => 'active',
                                    'rows' => 5
                            ])?>
                            <div class='drag-handle' draggable='true'>
                            <<?=NewsContent::$types[$content->type]?> contenteditable='true' name='NewsItem[content_old][<?=$content->id?>]'>
                                        <?=$content->content?>
                            </<?=NewsContent::$types[$content->type]?>>
                            </div>
                            <span class='dropdown btn btn-icon pull-right'>
                                <i class='icon material-icons'>more_vert</i>
                                <ul>
                                    <li class='item' io-method='removeNewsContent' io-method-params='datakey=<?=$content->id?>' behaviour='active'><span><i class='icon material-icons'>delete</i> Remove</span></li>
                                </ul>
                            </span>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class='col dt6 tb6 mb12 xs12 inner'></div>
    <div class='row row-btn'>
        <?=Html::button('Save', ['class' => 'btn btn-default action pull-right'])?>
        <a href="/news/index-item" class='btn btn-flat default-flat pull-right'><?=($model->isNewModel) ? 'Discard changes' : 'Cancel'?></a>
    </div>
    <?=$form->end()?>
</div>

<style>
    .html-edit{
        width: 100%; float: left; display: inline-block;
    }
    .html-edit-inner{
        border: 1px solid #aaa;
    }
    .html-edit-inner .row{
        position: relative;
        border-top: 1px solid transparent;
        border-bottom: 1px solid transparent;
    }
    .html-edit .drag-handle{
        display: inline-block;
        width: 100%;
        cursor: pointer;
        transition: all .3s ease-in-out;
        position: relative;
    }
    .html-edit .drag-handle + .dropdown{
        position: absolute;
        top: 10px; right: 10px;
        padding-right: 0;
    }
    .html-edit .drag-handle > *{
        display: block;
        min-height: 40px;
    }
    .html-edit .html-edit-inner .row:hover{
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }

</style>
<?php
$js = <<<JS
var sourceRow;
var cloneRow;
var contenteditable;
_(document).when('dragstart', '.drag-handle', function(e){
// $(".drag-handle").on('dragstart', function(e){
    console.log('start')
    sourceRow = this.parentNode;
    contenteditable = sourceRow.querySelector('[contenteditable="true"]');
    contenteditable.removeAttribute('contenteditable');
    cloneRow = this.parentNode.cloneNode(true);
    sourceRow.parentNode.insertBefore(cloneRow, sourceRow);
    cloneRow.style.display = 'none';

    console.log(contenteditable);
});
_(document).when('dragend', '.drag-handle', function(e){
    if(cloneRow){
        cloneRow.remove();
    }
    contenteditable.setAttribute('contenteditable', 'true')
    console.log('end');
});
_(document).when('dragenter', '.drag-handle', function(e){
    console.log('enter');
});
_(document).when('dragleave', '.drag-handle', function(e){
    console.log('leave');
});
_(document).when('dragover', '.drag-handle', function(e){
    e.preventDefault();

    index = $(this.parentNode).index();
    sourceIndex = $(sourceRow).index();

    length = this.parentNode.parentNode.children.length - 1;

    console.log(sourceRow);

    if(index == length){
        sourceRow.parentNode.append(sourceRow);
    } else {
        if(sourceIndex < index){
            sourceRow.parentNode.insertBefore(sourceRow, this.parentNode.nextSibling);
        } else {
            sourceRow.parentNode.insertBefore(sourceRow, this.parentNode);
        }
    }
});
_(document).when('drop', '.drag-handle', function(e){
// $(".drag-handle").on('drop', function(e){
    cloneRow.remove();
    console.log('drop');
});
_(document).when('input', '[contenteditable="true"]', function(e){
    var name = this.getAttribute('name');
    var textarea = _('textarea[name="'+name+'"]')[0];
    textarea.value = this.innerHTML;
});
JS;
$this->registerJs($js);

?>
