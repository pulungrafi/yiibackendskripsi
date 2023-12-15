<?php

use yii\helpers\ArrayHelper;

// Load the environment configuration if available
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Use Yii environment to determine the configuration dynamically
$isProduction = YII_ENV_PROD;

// Merge params
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

// Common configuration
$commonConfig = [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'hostInfo' => $_ENV['BACKEND_HOST_INFO'], // Sesuaikan dengan virtual host Anda
            'baseUrl' => '', // Biarkan kosong jika virtual host di-root
            'rules' => [
                'POST api/login' => 'site/login',
                'POST api/register' => 'site/register',
                'GET api/choose-role' => 'site/choose-role',
            ],
        ],
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key' => $_ENV['JWT_SECRET_KEY'], // Use environment variable
            'jwtValidationData' => [
                'iss' => 'http://digiternak.backend.test',
                'exp' => $isProduction ? time() + 3600 : time() + 3600 * 24 * 365, // 1 hour in dev, 1 year in production
            ],
        ],
    ],
    'params' => $params,
];

// Additional configuration for production
$productionConfig = [
    'components' => [
        // ... other production-specific components
    ],
];

// Merge configurations
$config = ArrayHelper::merge($commonConfig, $isProduction ? $productionConfig : []);

return $config;
