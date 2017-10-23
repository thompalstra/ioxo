<?php

use io\web\Url;
use io\widgets\Form;
use io\helpers\Html;

use io\widgets\Slidebox;
use common\models\NewsCategory;

?>
<div class='header header-default theme user'>
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
        <?=$form->field($model, 'news_category_id')->select(NewsCategory::getDataList(true), [])?>
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
                    <li class='item add-news-content' type='1' behaviour='active'><span>Regular</span></li>
                    <li class='item add-news-content' type='2' behaviour='active'><span>Code</span></li>
                    <li class='item add-news-content' type='3' behaviour='active'><span>Quote</span></li>
                </ul>
            </span>
        </div>
        <div id='news-content-collection' class='html-edit' style=''>
            <div style='border: 1px solid #aaa' id='news-content-collection-inner'>
                <?php
                foreach($model->content->all() as $content){
                    $out = "<div class='row'>";
                    $out .= Html::textarea(
                        "NewsItem[content_old][$content->id]",
                        $content->content,
                        [
                            'class' => 'hidden input input-default col dt12 tb12 mb12 xs12',
                            'behaviour' => 'active',
                            'rows' => 5
                        ]
                    );
                    switch($content->type){
                        case 1:
                            $out .= "<div class='drag-handle' draggable='true'>
                                        <div contenteditable='true' name='NewsItem[content_old][$content->id]'>
                                            $content->content
                                        </div>
                                    </div>";
                        break;
                        case 2:
                            $out .= "<div class='drag-handle' draggable='true'>
                                        <code>
                                            <div contenteditable='true' name='NewsItem[content_old][$content->id]'>
                                            $content->content
                                            </div>
                                        </code>
                                    </div>";
                        break;
                        case 3:
                            $out .= "<div class='drag-handle' draggable='true'>
                                        <blockquote contenteditable='true' name='NewsItem[content_old][$content->id]'>
                                            $content->content
                                        </blockquote>
                                    </div>";
                        break;
                    }
                    $out .= "</div>";

                    echo $out;
                }
                ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class='col dt6 tb6 mb12 xs12 inner'></div>
    <div class='row row-btn'>
        <?=Html::button('Save', ['class' => 'btn btn-default action pull-right'])?>
        <a href="/user/index" class='btn btn-flat default-flat pull-right'><?=($model->isNewModel) ? 'Discard changes' : 'Cancel'?></a>
    </div>
    <?=$form->end()?>
</div>

<style>
    .html-edit{
        width: 100%; float: left; display: inline-block;
    }
    .html-edit .drag-handle{
        display: inline-block;
        width: 100%;
        cursor: pointer;
        transition: all .3s ease-in-out;
        min-height: 40px;
        position: relative;
    }
    .html-edit .drag-handle:hover{
        background-color: #ddd;
    }
    .html-edit .drag-handle:hover:after{
        opacity: 1;
    }
    .html-edit .drag-handle:after{
        content: "●";
        color: orange;
        position: absolute;
        top: 0px;
        right: 5px;
        opacity: 0;
    }
</style>
<?php
$js = <<<JS
var sourceRow;
var cloneRow;
$(".drag-handle").on('dragstart', function(e){
    console.log('start')
    sourceRow = this.parentNode;
    cloneRow = this.parentNode.cloneNode(true);
    sourceRow.parentNode.insertBefore(cloneRow, sourceRow);
    cloneRow.style.display = 'none';
});
$(".drag-handle").on('dragend', function(e){
    if(cloneRow){
        cloneRow.remove();
    }
    console.log('end');
});
$(".drag-handle").on('dragenter', function(e){
    console.log('enter');
});
$(".drag-handle").on('dragleave', function(e){
    console.log('leave');
});
$(".drag-handle").on('dragover', function(e){
    e.preventDefault();

    index = $(this.parentNode).index();
    sourceIndex = $(sourceRow).index();

    length = this.parentNode.parentNode.children.length - 1;

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
$(".drag-handle").on('drop', function(e){
    cloneRow.remove();
    console.log('drop');
});
_(document).when('input', '[contenteditable="true"]', function(e){
    var name = this.getAttribute('name');
    var textarea = _('textarea[name="'+name+'"]')[0];
    textarea.value = this.innerHTML;
});
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
_(document).when('click', '.remove-news-content', function(e){
    $.ajax({
        url: '/news/remove-content',
        method: 'POST',
        data: {
            'content_id': this.getAttribute('data-key'),
        },
        success: function(resp){
            $('#news-content-collection').load( location.href + " #news-content-collection-inner" );
        }
    });
});
JS;
$this->registerJs($js);

?>
