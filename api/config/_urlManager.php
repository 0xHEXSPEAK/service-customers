<?php

use api\modules\api\v1\web\UrlParamHandler;

// Api url rules
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'class' => 'api\modules\api\v1\web\UrlRule',
            'controller' => 'api/v1/customer',
            'paramHandlers' => [
                'addressId' => [
                    UrlParamHandler::className(), 'decrement'
                ]
            ],
            'extraPatterns' => [
                'POST my/addresses' => 'create-address',
                'GET my/addresses/<addressId:\d+>' => 'view-address',
                'PUT my/addresses/<addressId:\d+>' => 'update-address',
                'DELETE my/addresses/<addressId:\d+>' => 'delete-address',
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
