<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
    ],
    'modules' => [
        'notifications' => [
            'class' => 'machour\yii2\notifications\NotificationsModule',
            // Point this to your own Notification class
            // See the "Declaring your notifications" section below
            'notificationClass' => 'common\components\Notification',
            // Allow to have notification with same (user_id, key, key_id)
            // Default to FALSE
            'allowDuplicate' => false,
            // This callable should return your logged in user Id
            'userId' => function() {
                return \Yii::$app->user->id;
            }
        ],
        // your other modules ..
    ],
    'timeZone' => 'America/Sao_Paulo',
    'language' => 'pt-BR',
    'sourceLanguage' => 'en-US',
];
