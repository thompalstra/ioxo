<?php
return [
    'url' => [
        'routes' => [
            [
                'class' => '\io\web\Url',
                ['a' => 'b']
            ],
            '/documentation/<category:(.*)>/<item:(.*)>' => '/documentation/item',
            '/documentation/<category:(.*)>' => '/documentation/category',
            '/documentation' => '/documentation/index'
        ],
    ],
    'language' => 'nl',
    'languages' => ['nl', 'en'],
    'identity' => [
        'class' => '\io\web\User'
    ],
    'enableCsrfValidation' => true,
    'csrfTimeout' => 60 * 60,
];
?>
