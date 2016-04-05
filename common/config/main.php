<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],       
        'formatter' => [
            'dateFormat' => 'php:d.m.Y',                                    
            'timeZone' => 'Europe/Moscow',
            'locale' => 'ru_RU',            
            'datetimeFormat' => 'php:H:i:s d.m.Y',
            'timeFormat' => 'php:H:i:s',
       ],
    ],
    'language' => 'ru-RU',
    
    'on beforeRequest' => function () {        
        //$timezone = Yii::$app->user->identity->timezone;
        if (!Yii::$app->user->isGuest) {
           // Yii::$app->formatter->timeZone = Yii::$app->user->identity->timezone;
        }
    },
    
];
