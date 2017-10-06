<?php
return [
    'url' => [
        'className' => '\io\web\Url',
        'routes' => [
            '/test/index' => '/default/index',
            '/default/test' => '/defualt/redirect'
        ],
    ],
    'identity' => [
        'class' => '\io\web\User'
    ],
    'enableCsrfValidation' => true,
    'csrfTimeout' => 30,
];
?>
