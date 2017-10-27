<?php
use io\widgets\DataTable;
use io\helpers\Html;
use io\web\Url;
?>


<div class='col xs12 header header-default'>
<div class='container'>
    <h1 class='title'>News <i class="material-icons icon pull-right">&#xE853;</i></h1>
    <?=$searchModel->console()?>
</div>
</div>
<div class='container'>
    <div class='row row-btn'>
        <?=Html::a('<i class="material-icons icon pull-left">&#xE8B6;</i> VIEW CATEGORIES', Url::to('/news/index-category'), ['class' => 'btn btn-icon btn-default success pull-right'] )?>
        <?=Html::a('<i class="material-icons icon pull-left">&#xE145;</i> NEW ITEM', Url::to('/news/view-item'), ['class' => 'btn btn-icon btn-default success pull-right'] )?>
    </div>
<?=DataTable::widget([
    'dataSet' => $dataSet,
    'pager' => false,
    'columns' => [
        '' => [
            'options' => [
                'width' => '40',
                'style' => [
                    'text-align' => 'center'
                ]
            ],
            'value' => function($model){
                return Html::input("select[$model->id]", $model->id, ['type' => 'checkbox']);
            }
        ],
        'title',
        'category' => [
            'options' => [

            ],
            'value' => function($model){
                return Html::a('<span>' . $model->category->title . '</span>', Url::to('/news/view-category', ['id' => $model->category->id]), [] );
            }
        ],
        'is_enabled' => [
            'options' => [
                'width' => '40',
                'style' => [
                    'text-align' => 'center'
                ]
            ],
            'label' => '',
            'value' => function($model){
                return ($model->is_enabled) ? '<i class="material-icons">&#xE5CA;</i>' : '';
            }
        ],
        'trash' => [
            'options' => [
                'width' => '40',
                'style' => [
                    'text-align' => 'center'
                ],
            ],
            'label' => '',
            'value' => function($model){
                return "<i class='material-icons delete'>&#xE872;</i>";
            }
        ],
        'view' => [
            'options' => [
                'width' => '40',
                'style' => [
                    'text-align' => 'center'
                ],
            ],
            'label' => '',
            'value' => function($model){
                return "<a href='/news/view-item?id=$model->id'><i class='material-icons'>&#xE8B6;</i></a>";
            }
        ]
    ],
    'rowOptions' => [
        'class' => 'row'
    ]
]);?>
</div>

<?php
$js = <<<JS
console.log(Application);
_(document).when('click', '.delete', function(e){
    e.preventDefault();
    e.stopPropagation();
    if(confirm("Do you want to delete the selected item(s)?")){
        var tbody = $(this.parentNode.parentNode.parentNode);
        var checked = $(tbody.find('tr input[type="checkbox"]:checked'));
        if(checked.length == 0){
            location.href = "/news/delete-item?id=" + this.parentNode.parentNode.getAttribute('datakey');
        } else {
            var ids = [];
            checked.each(function(index){
                ids.push( this.value );
            });
            location.href = "/news/delete-item?ids=" + JSON.stringify(ids);
        }
    }
});
JS;
$this->registerJs($js);
?>