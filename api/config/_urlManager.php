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
            'extraPatterns' => [
                'POST my/addresses' => 'create-address',
            ],
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'api/v1/country',
            'except' => ['delete', 'create', 'update'],
            'extraPatterns' => [
                'GET <iso2>/states' => 'states',
            ],
        ]
    ]
];
