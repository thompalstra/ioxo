<?php
return [
    'url' => [
        'className' => '\io\web\Url',
        'routes' => [
            '/test/index' => '/default/index',
            '/default/test' => '/defualt/redirect'
        ],
    ],
    'language' => 'nl',
    'languages' => ['nl', 'en'],
    'identity' => [
        'class' => '\io\web\User'
    ],
    'enableCsrfValidation' => true,
    'csrfTimeout' => 60 * 60 * 24,
];
?>
