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
        <?=Html::a('NIEUW', Url::to('/auth/view', ['a' => 'b', 'c' => 'd']), ['class' => 'btn btn-default success pull-right'] )?>
    </div>
<?=DataTable::widget([
    'dataSet' => $dataSet,
    'columns' => [
        'id' => [
            'options' => [
                'width' => '80',
                'style' => [
                    'text-align' => 'center'
                ]
            ]
        ],
        'name' => [
            'value' => function($model){
                return $model->name;
            },
        ],
    ],
    'rowOptions' => [
        'class' => 'row',
        'onclick' => 'location.href = "/auth/view?id=" + this.getAttribute("datakey")',
        'title' => 'click to edit this role'
    ]
]);?>
</div>
