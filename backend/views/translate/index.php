<?php
use io\widgets\DataTable;
use io\helpers\Html;
use io\web\Url;
?>


<div class='col xs12 header header-default'>
<div class='container'>
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
        'select' => [
            'options' => [
                'width' => ''
            ],
            'value' => function($model){
                return Html::input("select[$model->id]", $model->id, ['type' => 'checkbox']);
            }
        ],
        'id' => [
            'options' => [
                'width' => '80',
                'style' => [
                    'text-align' => 'center'
                ]
            ]
        ],
        'source_message' => [
            'options' => [
                'title' => "click to edit",
                'onclick' => 'location.href = "/translate/view?id=" + this.parentNode.getAttribute("datakey")'
            ],
            'value' => function($model){
                return $model->source_message;
            },
        ],
        'trash' => [
            'value' => function($model){
                return "<i class='material-icons delete'>&#xE872;</i>";
            }
        ],
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
