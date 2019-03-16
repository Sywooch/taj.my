<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',

    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
		'@adminlte/widgets'=>'@vendor/adminlte/yii2-widgets',
    ],
    'components' => [
		'authManager' => [
            'class' => 'yii\rbac\DbManager',
		],
        'authClientCollection' => [
            'class'   => \yii\authclient\Collection::className(),
            'clients' => [
               /* 'facebook' => [
                    'class'        => 'dektrium\user\clients\Facebook',
                    'clientId'     => '814710812204315',
                    'clientSecret' => '18bdc9d9b314d69ad490bd6eff642e48',
                ],*/
            ],
        ],
		'assetManager' => [
			'bundles' => [
				'dmstr\web\AdminLteAsset' => [
					'skin' => 'skin-yellow-light',
				],
			],
		],
        'request' => [
            'baseUrl' => '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Q0MXW38G515D1tQwcIw0DBLZum5cVyjx',
            'class' => 'klisl\languages\Request',
        ],
        'cache'=>[
			'class'=>'yii\caching\DbCache',
		],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'reCaptcha' => [
			'name' => 'reCaptcha',
			'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
			'siteKey' => '6LcP3o4UAAAAAGa3quXYqwZblrcGB-Oiw57woRns',
			'secret' => '6LcP3o4UAAAAANEhs8U2VqGFpvHtQV4AcvvW2TPi',
		],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.beget.com',
                'username' => 'info@tajrobtak.com',
                'password' => 's6jAP%S7',
                'port' => '465',
                'encryption' => 'ssl',
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'class' => 'klisl\languages\UrlManager',
            'rules' => [

                'languages' => 'languages/en/common', //для модуля мультиязычности

                '/' => 'site/index',
                'reviews/<page:\d+>'=>'site/index',

                'products/<link:[\w-]+>/<page:\d+>'=>'product/category',
                'products/<link:[\w-]+>'=>'product/category',

                'product/addreview' => 'product/addreview-with-category',
                'product/<category_link:[\w-]+>/<link:[\w-]+>/<new:[\w-]+>'=>'product/addreview',
                'product/<category_link:[\w-]+>/<link:[\w-]+>/<page:\d+>'=>'product/product',
                'product/<category_link:[\w-]+>/<link:[\w-]+>'=>'product/product',
                'addProduct'    => 'product/createnew',

                'review/<product_link:[\w-]+>/<link:[\w-]+>'=>'product/review',

                'information/<link:[\w-]+>' => 'information/content',

                'users/<user_id:\d+>/<action:(index|reviews|info)>' => 'users/<action>',
                'users/<user_id:\d+>' => 'users/info',

                'upload/subimageupload' => 'upload/subImageUpload',

                'user/reviews/<page:\d+>' => 'user-data/user-reviews',
                'user/reviews' => 'user-data/user-reviews',
                'user/billing' => 'user-data/user-billing',
                'user/dialog' => 'user-data/user-dialog',
                'dialog/<dialog_id:\d+>' => 'user-data/user-dialog-show',

                'users/<user_id:\d+>' => 'user-data/user-show',
                'users/<user_id:\d+>/<page:\d+>' => 'user-data/user-show',

                'ajax/<action:\w+>' => 'ajax/<action>',
                '<action:(contact|login|logout|language|about|signup)>' => 'site/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'  => '<controller>/<action>',


                'products'   =>  'product/index',

            ],
        ],

        'i18n' => [
          'translations' => [
              '*'     =>  [
                    'class'     =>  'yii\i18n\PhpMessageSource',
                    //'basePath'  =>  '@app\messages',
              ],
          ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
			'enableFlashMessages' => true,
            'admins' => ['a'],
        ],
        'languages' => [
            'class' => 'klisl\languages\Module',
            //Языки используемые в приложении
            'languages' => [
                'English' => 'en',
                'العربية' => 'ar',
            ],
            'default_language' => 'en', //основной язык (по-умолчанию)
            'show_default' => false, //true - показывать в URL основной язык, false - нет
        ],
		'adminpanel' => [
            'class' => 'app\modules\administrator\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['176.36.17.12'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['176.36.17.12', '::1'],
    ];
}

return $config;
