<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'name' => 'Personal Aqui',
    'language' => 'pt-BR',
    'timeZone' => 'America/Recife',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module',
        ],

    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'api\modules\v1\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => 'v1/list-all',
                    'except' => ['index', 'delete', 'create', 'update'],
                    'extraPatterns' => [
                        'OPTIONS <whatever:.*>' => 'options',
                        'GET states' => 'states',
                        'GET cities-from-state/<id:\d+>' => 'cities-from-state',
                        'GET companies' => 'companies',
                        'GET company-markets' => 'company-markets',
                        'GET tag' => 'tags',
                        'GET tag-types' => 'tag-types',
                        'GET professional' => 'professionals',
                        'GET professional-types' => 'professional-types',
                        'GET age-groups' => 'age-groups',
                        'GET price-ranges' => 'price-ranges',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/user-per-company',
                    'only' => ['create', 'options']
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/user',
                    'extraPatterns' => [
                        'OPTIONS <whatever:.*>' => 'options',
                        'POST login' => 'login',
                        'POST find-by-email' => 'find-by-email'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/promotion',
                    'extraPatterns' => [
                        'OPTIONS <whatever:.*>' => 'options',
                        'POST <id:\d+>/approve' => 'approve',
                        'POST <id:\d+>/reject' => 'reject'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/gallery',
                    'extraPatterns' => [
                        'OPTIONS <whatever:.*>' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/upload',
                    'tokens' => ['{id}' => '<id:\w+>'],
                    'except' => ['update']
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/company',
                        'v1/company-market',
                        'v1/company-status',
                        'v1/tag',
                        'v1/tag-type',
                        'v1/professional',
                        'v1/professional-type',
                        'v1/age-group',
                        'v1/price-range',
                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
];
