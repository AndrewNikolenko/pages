<?php

namespace eapanel\pages\controllers;

use Yii;
use yii\web\HttpException;
use eaPanel\pages\models as models;
use yii\helpers\Inflector;
use dosamigos\transliterator\TransliteratorHelper;

use howard\behaviors\iwb\InlineWidgetsBehavior;

class MainController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'InlineWidgetsBehavior'=> [
                'class'=> InlineWidgetsBehavior::className(),
                'namespace'=> 'app\modules\eaPanel\components',               
                'widgets'=>Yii::$app->params['runtimeWidgets'],
                'startBlock'=> '[*',
                'endBlock'=> '*]',
                'classSuffix'=> 'Widget',
             ],
        ];
    }
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => 'http://start-app.loc/images/',
                'path' => '@webroot/images'
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => 'http://start-app.loc/images/',
                'path' => '@webroot/images',
                'type' => \vova07\imperavi\actions\GetAction::TYPE_IMAGES,
            ],
            'file-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => 'http://start-app.loc/files/',
                'path' => '@webroot/files'
            ],
            'files-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => 'http://start-app.loc/files/',
                'path' => '@webroot/files',
                'type' => \vova07\imperavi\actions\GetAction::TYPE_FILES,
            ]
        ];
    }
    
    public function actionIndex()
    {        
        return $this->render('index');
    }
    
    public function actionView()
    {
        $page = new models\Page(['filename'=> \Yii::$app->request->get('id')]);
        $title = $page->getPageName();
        $content = $this->decodeWidgets($page->getPageContent());
        
        if(!$page->exists())
        {
            throw new HttpException(404,  \Yii::t('messages','Page not found'));
        }
        return $this->render($page->filename, [
            'title'   => $title,
            'content' => $content
        ]);
    }    
    
    public function actionContact()
    {
        $model = new models\ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    
}
