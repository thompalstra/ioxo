<?php
return [
    'url' => [
        'routes' => [
            [
                'class' => '\io\web\Url',
                ['a' => 'b']
            ],
            '/documentation' => '/documentation/index',
            '/documentation/<category:(.*)>' => '/documentation/category',
            '/documentation/<category:(.*)>/<item:(.*)>' => '/documentation/item'

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
