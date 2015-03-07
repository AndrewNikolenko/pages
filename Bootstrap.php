<?php

namespace eapanel\pages;

use yii\base\BootstrapInterface;
use yii\base\Application;

class Bootstrap implements BootstrapInterface
{
    /** @var array Model's map */
    private $_modelMap = [
        'User'             => 'dektrium\user\models\User',
        'Account'          => 'dektrium\user\models\Account',
        'Profile'          => 'dektrium\user\models\Profile',
        'Token'            => 'dektrium\user\models\Token',
        'RegistrationForm' => 'dektrium\user\models\RegistrationForm',
        'ResendForm'       => 'dektrium\user\models\ResendForm',
        'LoginForm'        => 'dektrium\user\models\LoginForm',
        'SettingsForm'     => 'dektrium\user\models\SettingsForm',
        'RecoveryForm'     => 'dektrium\user\models\RecoveryForm',
        'UserSearch'       => 'dektrium\user\models\UserSearch',
    ];

    /** @inheritdoc */
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () {
             return [
                'components' => [
                    'urlManager' => [
                        'enablePrettyUrl' => true,
                        'showScriptName' => false,
                        'rules' => [
                            'page/<_c:(admin)>/index' => 'pages/admin/index',
                            'page/<_a:(create)>' => 'pages/admin/<_a>',
                            'page/<_a:(update)>/<id:[\w\-]+>' => 'pages/admin/update',
                            'page/<_a:(delete)>/<id:[\w\-]+>' => 'pages/admin/delete',
                            'page/<_a:(remove)>/<id:[\w\-]+>' => 'pages/admin/remove',
                            'page/<_a:(restore)>/<id:[\w\-]+>' => 'pages/admin/restore',
                            'page/<_a:(dropdown)>' => 'pages/admin/dropdown',
                            'page/<_a:(dropdown)>' => 'pages/admin/dropdown',
            
                            'page/<_a:(a)>' => 'pages/admin/a',
                            'page/<_a:(b)>' => 'pages/admin/b',
                            'page/<_a:(c)>' => 'pages/admin/c',
            
                            'page/<_a:(contact)>' => 'pages/main/<_a>',
                            'page/<id:[\w\-]+>' => 'pages/main/view',
                        ],
                    ],
                ],
             ];
        });
    }
}