<?php
use kartik\mpdf\Pdf;
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],        
    ],
    'modules' => [
  
        'markdown' => [
            'class' => 'kartik\markdown\Module',
            
        // the controller action route used for markdown editor preview
        'previewAction' => '/parse/preview',
            
        'downloadAction' => '/parse/download',
 
        // the list of custom conversion patterns for post processing
        'customConversion' => [
            '<table>' => '<table class="table table-bordered table-striped">'
        ],
 
        // whether to use PHP SmartyPantsTypographer to process Markdown output
        'smartyPants' => true
        ]
    ],
    'aliases' => [
        '@mathjax' => '@vendor/mathjax/mathjax',
    ],
    'params' => $params,
];
