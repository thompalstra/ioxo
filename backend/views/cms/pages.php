<?php
    $this->title = 'Page index';
?>
<style>
    .datatable td[data-name="view"] .btn{
        width: 100%;
        margin-bottom: 10px;
    }
</style>
<div id='w0-datatable-1'>
    <?php

    $dataSource = [];
    $searchColumns = [ 'page_name' ];
    foreach( $dataProvider->getModels() as $model ){
        foreach( Scope::$app->_language->supported as $language ){
             $links[] = "<a class='btn btn-small flat-to-default action' href='/cms/pages/view?id=$model->id&language=$language'>$language</a>";
        }

        $dataSource[][ $model->id]  = [ $model->page_name, implode('',$links) ];
    }
    $dataColumns = [
        'page_name' => 'Page name',
        'view' => 'view'
    ];

    // var_dump($dataSource); die;
    ?>
</div>
<script>
    document.listen('ready', function(e){
        var dataSource = [];
        var i = 1;
        while(i<=99){
            var obj = {};
            var isActive = Math.floor(Math.random() * (1 - 0 + 1)) + 0;
            var mailValidated = Math.floor(Math.random() * (1 - 0 + 1)) + 0;
            var mailSubscribed = Math.floor(Math.random() * (1 - 0 + 1)) + 0;
            var mails = ['gmail', 'yahoo', 'hotmail', 'outlook', 'live'];
            var mail = mails [ Math.floor(Math.random()*( ( mails.length -1 ) - ( 0 ) +1)+( 0 )) ];

            obj[i] = [i, 'username_' + i, 'email@' +mail+ '.com', isActive, mailValidated, mailSubscribed];
            dataSource.push(obj);
            i++;
        }
        console.log( dataSource );
        console.log( <?=json_encode($dataSource, true)?> );

        // var dataColumns = {
        //     id: '#',
        //     username: 'user',
        //     email: 'mail',
        //     is_active: 'active',
        //     is_mail_validated: 'validated',
        //     is_mail_subscribed: 'subscribed'
        // };
        // var searchColumns = ['id', 'username', 'email'];

        var dt = new Scope.widgets.Datatable({
            element: document.findOne('#w0-datatable-1'),
            dataSource: <?=json_encode($dataSource, true)?>,
            dataColumns: <?=json_encode($dataColumns)?>,
            searchColumns: <?=json_encode($searchColumns)?>
        });
        dt.construct();
    });
</script>
