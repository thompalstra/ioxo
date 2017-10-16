<?php
use io\widgets\Breadcrumb;
?>
<div class='col xs12 header header-default theme default'>
<div class='container'>
    <?=Breadcrumb::widget([
        'items' => [
            [
                'url' => '/',
                'label' => 'Home'
            ],
            [
                'url' => '/about-ioxo',
                'label' => 'About IOXO'
            ]
        ],
        'options' => [
            'class' => 'breadcrumb breadcrumb-default'
        ],
        'itemOptions' => [
            'class' => 'item'
        ],
    ])?>
    <h1>About IOXO</h1>
</div>
</div>
<div class='container'>

</div>
