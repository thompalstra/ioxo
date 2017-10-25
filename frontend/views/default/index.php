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
            ]
        ],
        'options' => [
            'class' => 'breadcrumb breadcrumb-default'
        ],
        'itemOptions' => [
            'class' => 'item'
        ],
    ])?>
</div>
</div>
<div class='container'>
    <div class='row row-element'>
        <a href="/about/ioxo">
            <div class='col dt8 tb8 mb12 xs12 element'>
                <div class='inner default' behaviour="active">
                    <h2>About IOXO</h2>
                    <p>Learn more about IOXO</p>
                </div>
            </div>
        </a>
        <a href="/documentation">
            <div class='col dt4 tb4 mb12 xs12 element'>
                <div class='inner info' behaviour="active">
                    <h2>Documentation</h2>
                    <p>Take a look at IOXO's documentation</p>
                </div>
            </div>
        </a>
    </div>

    <div class='row row-element'>
        <a href="/documentation/general/why-use-ioxo">
            <div class='col dt4 tb4 mb12 xs12 element'>
                <div class='inner epic' behaviour="active">
                    <h2>Why use IOXO?</h2>
                </div>
            </div>
        </a>
        <a href="/about/the-team">
            <div class='col dt4 tb4 mb12 xs12 element'>
                <div class='inner action' behaviour="active">
                    <h2>About us</h2>
                </div>
            </div>
        </a>
        <a href="/news">
            <div class='col dt4 tb4 mb12 xs12 element'>
                <div class='inner success' behaviour="active">
                    <h2>Latest news</h2>
                </div>
            </div>
        </a>
    </div>
</div>
