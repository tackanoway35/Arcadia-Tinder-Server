<?php

$params = require(__DIR__ . '/params.php');

$basePath =  dirname(__DIR__);
$webroot = dirname($basePath);

$config = [
    'id' => 'app',
    'basePath' => $basePath,
    'bootstrap' => ['log'],
    'language' => 'en-US',
    'runtimePath' => $webroot . '/runtime',
    'vendorPath' => $webroot . '/vendor',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Taw-bEVfxUQFOK34nWvxSN_JFdQgwtvM',
//            'parsers' => [
//                'application/json' => 'yii\web\JsonParser',
//            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
//            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'member-api',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'pluralize' => FALSE,
                    'extraPatterns' => [
                        'GET check-unique-login-facebook/<facebook_id:\d+>' => 'check-unique-login-facebook',
                        'POST update-facebook-member' => 'update-facebook-member',
                        'GET check-unique-username/<username:\\w+>' => 'check-unique-username',
                        'GET check-unique/<id:\d+>' => 'check-unique',
                        'POST login-by-app' => 'login-by-app',
                        'GET get-contact/<id:\d+>' => 'get-contact',
                        'POST set-require-information' => 'set-require-information',
                        'POST update-member' => 'update-member' 
                        
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'image-api',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'pluralize' => FALSE,
                    'extraPatterns' => [
                        'GET check-image-exit/<member_id:\d+>' => 'check-image-exit',
                        'POST update-image' => 'update-image',
                        'GET get-member-image/<member_id:\d+>' => 'get-member-image'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'require-api',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'pluralize' => FALSE,
                    'extraPatterns' => [
                        'GET check-unique-require-information/<member_id:\d+>' => 'check-unique-require-information',
                        'POST update-require-information' => 'update-require-information',
                        'GET get-distance/<member_id:\d+>' => 'get-distance',
                        'GET get-detail/<member_id:\d+>' => 'get-detail'
                    ]
                ],
                '<controller:\w+>/view/<slug:[\w-]+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/cat/<slug:[\w-]+>' => '<controller>/cat',
            ],
        ],
        'assetManager' => [
            // uncomment the following line if you want to auto update your assets (unix hosting only)
            //'linkAssets' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [YII_DEBUG ? 'jquery.js' : 'jquery.min.js'],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [YII_DEBUG ? 'css/bootstrap.css' : 'css/bootstrap.min.css'],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [YII_DEBUG ? 'js/bootstrap.js' : 'js/bootstrap.min.js'],
                ],
            ],
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
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
    
    $config['components']['db']['enableSchemaCache'] = false;
}

return array_merge_recursive($config, require($webroot . '/vendor/noumo/easyii/config/easyii.php'));