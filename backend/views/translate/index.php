<?php
use io\widgets\DataTable;
use io\helpers\Html;
use io\web\Url;
?>


<div class='col xs12 header header-default'>
<div class='container'>
    <h1 class='title'>Translate <i class="material-icons icon pull-right">&#xE8E2;</i></h1>
    <?=$searchModel->console()?>

</div>
</div>
<div class='container'>
    <div class='row row-btn'>
        <?=Html::a('<i class="material-icons icon pull-left">&#xE145;</i> NIEUW', Url::to('/translate/view', ['a' => 'b', 'c' => 'd']), ['class' => 'btn btn-icon btn-default success pull-right'] )?>
    </div>
<?=DataTable::widget([
    'dataSet' => $dataSet,
    'columns' => [
        '' => [
            'options' => [
                'width' => '40',
                'style' => [
                    'text-align' => 'center'
                ]
            ],
            'label' => '',
            'value' => function($model){
                return Html::input("select[$model->id]", $model->id, ['type' => 'checkbox']);
            }
        ],
        'source_message' => [
            'value' => function($model){
                return $model->source_message;
            },
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
                return "<a href='/translate/view?id=$model->id'><i class='material-icons'>&#xE8B6;</i></a>";
            }
        ]
    ],
    'rowOptions' => [
        'class' => 'row',
    ]
]);?>
</div>

<?php
$js = <<<JS
$(document).on('click', '.delete', function(e){
    e.preventDefault();
    e.stopPropagation();
    if(confirm("Do you want to delete the selected this item(s)?")){
        var tbody = $(this.parentNode.parentNode.parentNode);
        var checked = $(tbody.find('tr input[type="checkbox"]:checked'));
        if(checked.length == 0){
            location.href = "/translate/delete?id=" + this.parentNode.parentNode.getAttribute('datakey');
        } else {
            var ids = [];
            checked.each(function(index){
                ids.push( this.value );
            });
            location.href = "/translate/delete?ids=" + JSON.stringify(ids);
        }
    }
});
JS;
$this->registerJs($js);
?>
