<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'name' => 'Match Jobs',
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
                        'GET tag' => 'tags',
                        'GET resume' => 'resumes',
                        'GET job' => 'jobs',
                        'GET job-alert' => 'jobs-alert',
                        'GET job-application' => 'jobs-application',
                        'GET contac' => 'contacts',
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
                        'v1/job',
                        'v1/job-alert',
                        'v1/job-application',
                        'v1/tag',
                        'v1/resume',
                        'v1/contact',
                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
];
