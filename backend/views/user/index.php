<?php
use io\widgets\DataTable;
use io\helpers\Html;
use io\web\Url;
?>


<div class='col xs12 header header-default theme user'>
<div class='container'>
    <?=$searchModel->console()?>
</div>
</div>
<div class='container'>
    <div class='row row-btn'>
        <?=Html::a('<i class="material-icons icon pull-left">&#xE145;</i> NIEUW', Url::to('/user/view', ['a' => 'b', 'c' => 'd']), ['class' => 'btn btn-icon btn-default success pull-right'] )?>
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
        'username' => [
            'options' => [
                'title' => "click to edit",
                'onclick' => 'location.href = "/user/view?id=" + this.parentNode.getAttribute("datakey")'
            ],
            'value' => function($model){
                return $model->username;
            }
        ],
        'is_enabled' => [
            'options' => [
                'width' => '80',
                'style' => [
                    'text-align' => 'center'
                ]
            ],
            'value' => function($model){
                return ($model->is_enabled) ? '<i class="material-icons">&#xE5CA;</i>' : '';
            }
        ],
        'trash' => [
            'width' => '80',
            'style' => [
                'text-align' => 'center'
            ],
            'value' => function($model){
                return "<i class='material-icons delete'>&#xE872;</i>";
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
$(document).on('click', '.delete', function(e){
    e.preventDefault();
    e.stopPropagation();
    if(confirm("Do you want to delete this item?")){
        location.href = "/user/delete?id=" + this.parentNode.parentNode.getAttribute('datakey');
    }
});
JS;
$this->registerJs($js);
?>
