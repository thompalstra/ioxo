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
        <?=Html::a('NIEUW', Url::to('/user/view', ['a' => 'b', 'c' => 'd']), ['class' => 'btn btn-default success pull-right'] )?>
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
        'username' => [
            'value' => function($model){
                return $model->username;
            },
        ],
        'is_enabled' => [
            'value' => function($model){
                return ($model->is_enabled) ? '<i class="material-icons">&#xE5CA;</i>' : '';
            },
            'options' => [
                'width' => '80',
                'style' => [
                    'text-align' => 'center'
                ]
            ]
        ]
    ],
    'rowOptions' => [
        'class' => 'row',
        'onclick' => 'location.href = "/user/view?id=" + this.getAttribute("datakey")',
        'title' => 'click to edit this account'
    ]
]);?>
</div>
