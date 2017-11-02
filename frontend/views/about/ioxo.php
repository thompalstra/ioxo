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
        <div id='dialog-1' class='dialog' dialog-ok='Ok' dialog-cancel='Cancel' dialog-speed="slow" backdrop>
            <div class='content'>
                <p><strong>Cookies</strong></p>
                <p>To use this website to it's full extend, we need to know if you accept cookies and temporary files to let us store some temporary data</p>
                <p>For example: <br>
                    <ul>
                        <li>When using a search form, some of the search values may be temporarily stored</li>
                    </ul>
                </p>
            </div>
        </div>
        <div class='dialog-backdrop'></div>

        <div id='alert-1' class='alert' alert-ok='Ok' backdrop>
            <div class='content'>
                <p><strong>Alert!</strong></p>
                <p>You absolutely <u>have</u> to click the <strong>OK</strong><br/>
                You have been warned, now do it!</p>
            </div>
        </div>
        <div class='alert-backdrop'></div>
    <div class='row'>
        <h2>some examples</h2>

        <div id='event-tracker' class='row' style='height: 250px; background-color: #333; padding: 10px; color: white;'></div>

        <div class='row prow'>
            <button id='show-dialog-1' class='btn btn-default success'>Show Dialog</button>
            <button id='show-alert-1' class='btn btn-default success'>Show Alert</button>
        </div>
        <div class='row prow'>
            <div behaviour="active" id="user-is_enabled" placeholder="Enabled" tinyint="" class="slidebox" name="User[is_enabled]">
                <input name="User[is_enabled]" value="true" type="hidden">
                <div class="wrapper">
                    <div class="true">Yes</div>
                    <div class="false">No</div>
                    <div class="indicator"></div>
                </div>
            </div>
        </div>
        <div class='row prow'>
            <input type='search' for="[name='User[usedRoles][]']" class='input input-default  col dt12 tb12 mb12 xs12'/>
            <select multiple="true" id="user-usedroles[]" placeholder="Used roles" class="input input-default col dt12 tb12 mb12 xs12" name="User[usedRoles][]">
                <option value="">None</option>
                <option value="1">Bananas</option>
                <option value="2">Strawberries</option>
                <option value="3">Pineapples</option>
                <option value="4">Oranges</option>
                <option value="5">Apples</option>
            </select>
        </div>
    </div>



    </div>
</div>


<?php
$js = <<<JS


var eventTracker = _('#event-tracker');

_(document).when('click', '#show-dialog-1', function(e){
    new Dialog( _("#dialog-1")[0] ).show();
});
_(document).when('click', '#show-alert-1', function(e){
    new Alert( _("#alert-1")[0] ).show();
});

_(document).when('ok cancel beforeShow afterShow beforeHide afterHide', '#dialog-1', function(e){
    eventTracker.insert( _("<p>Triggered event: " + e.type + " for " + e.target.id + "</p>") );
    eventTracker[0].scrollTop = eventTracker[0].scrollHeight;
});
_(document).when('ok cancel beforeShow afterShow beforeHide afterHide', '#alert-1', function(e){
    eventTracker.insert( _("<p>Triggered event: " + e.type + " for " + e.target.id + "</p>") );
    eventTracker[0].scrollTop = eventTracker[0].scrollHeight;
});
JS;
$this->registerJs($js);

?>
