<?php
use io\widgets\DataTable;
use io\helpers\Html;
use io\web\Url;
?>
<div>
    <?=""
    // Html::button('NIEUW', ['class' => 'btn btn-default success pull-right'])
    ?>

    <?=Html::a('NIEUW', Url::to('/user/view', ['a' => 'b', 'c' => 'd']), ['class' => 'btn btn-default success pull-right'] )?>
</div>
<?=$searchModel->console()?>
<?=DataTable::widget([
    'dataSet' => $dataSet,
    'columns' => [
        'id',
        'name' => [
            'label' => 'Name',
            'options' => [
                'class' => 'der'
            ],
            'value' => function($model){
                return $model->username;
            },
        ],
        'is_enabled',
    ],
    'rowOptions' => [
        'class' => 'row',
        'onclick' => 'location.href = "/user/view?id=" + this.getAttribute("datakey")'
    ]
]);?>
