<?php
// Api url rules
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'api/v1/customer',
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'api/v1/country',
            'except' => ['delete', 'create', 'update'],
            'extraPatterns' => [
                'GET <id>/states' => 'states',
            ],
        ]
    ]
];
