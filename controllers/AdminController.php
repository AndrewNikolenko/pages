<?php

namespace eapanel\pages\controllers;

use Yii;
use yii\web\HttpException;
use eaPanel\pages\models as models;
use yii\helpers\Html;
use yii\helpers\Inflector;
use dosamigos\transliterator\TransliteratorHelper;
use yii\helpers\Json;

use howard\behaviors\iwb\InlineWidgetsBehavior;

class AdminController extends \yii\web\Controller
{
    private $viewsPath = '@app/views/main';
    private $viewsPathInactive = '@app/views/inactive';

    public $layout = '/admin';
    
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

    public function actionMenu()
    {
        if(Yii::$app->request->post()) {
            $data = json_decode($_POST['pages'], true);

            $menu = new models\Menu();
            $root = $menu->find()->where('name=:name', [':name'=>'Pages'])->asArray()->all();
            if(!empty($root)) {
                $rootId = $root[0]['id'];
                $menu->deleteAll(['tree'=>$rootId]);
            }

            $pages = new models\Menu(['name' => 'Pages']);
            $pages->makeRoot();
            foreach($data as $element)
            {
                $item = new models\Menu(['name' => $element]);
                $item->prependTo($pages);
            }
        }
    }

    public function actionIndex()
    {
        //Все статические страницы
        $model = new models\Page();
        $pages = $model->findAll();

        $items = [];
        foreach($pages as $page)
        {
            $object = new models\Page(['filename' => $page]);
            $filename = explode('main\\',$object->filename);
            $file = file(\Yii::getAlias($this->viewsPath) . '/' . $filename[1]);
            $label = explode('PageName: ', $file[2]);
            $id = explode('.', $filename[1])[0];

            $items[$label[1]] = [
                'content' => '<p class="menuLabel">' . $label[1] . '</p>'
                . '<p class="actionButtons">'
                . Html::a('<i class="glyphicon glyphicon-ok-circle"></i>', ['/page/'.$id.''], ['class'=>'', 'title'=>Yii::t('admin', 'goToPage')])
                . Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['//page/update/'.$id.''], ['class'=>'updatePage', 'title'=>Yii::t('admin', 'updatePage')])
                . Html::a('<i class="glyphicon glyphicon-remove-sign"></i>', ['/page/delete/'.$id.''], ['class'=>'deletePage', 'title'=>Yii::t('admin', 'deletePage')])
                . '</p>' . '<div class="clearfix"></div>',
            ];
        }

        //Меню
        $menu = models\Menu::find()->where('depth=:depth', [':depth'=>1])->asArray()->all();

        $menuItems = [];
        foreach($menu as $element)
        {
            $menuName = Inflector::slug( TransliteratorHelper::process( $element['name'] ), '-', 'en' );

            $menuItems[$element['name']] = [
                'content' => '<p class="menuLabel">' . $element['name'] . '</p>'
                    . '<p class="actionButtons">'
                    . '<i class="glyphicon glyphicon-trash dropMenu" title="'.Yii::t('admin', 'removeItem').'"></i>'
                    . '</p>' . '<div class="clearfix"></div>', 'disabled'=>true
            ];
        }

        //Неактивные
        $inactiveModel = new models\Page();
        $inactivePages = $inactiveModel->findAllInactive();

        $inactiveItems = [];
        foreach($inactivePages as $page)
        {
            $object = new models\Page(['filename' => $page]);
            $filename = explode('inactive\\',$object->filename);
            $file = file(\Yii::getAlias($this->viewsPathInactive) . '/' . $filename[1]);
            $label = explode('PageName: ', $file[2]);
            $id = explode('.', $filename[1])[0];

            $inactiveItems[$label[1]] = [
                'content' => '<p class="menuLabel">' . $label[1] . '</p>'
                    . '<p class="actionButtons">'
                    . Html::a('<i class="glyphicon glyphicon-arrow-up"></i>', ['/page/restore/'.$id.''], ['class'=>'restorePage', 'title'=>Yii::t('admin', 'Restore Page')])
                    . Html::a('<i class="glyphicon glyphicon-trash"></i>', ['/page/remove/'.$id.''], ['class'=>'removePage', 'title'=>Yii::t('admin', 'deletePage')])
                    . '</p>' . '<div class="clearfix"></div>', 'disabled'=>true,
            ];
        }
        
        return $this->render('index', [
            'items'=>$items,
            'menuItems'=>$menuItems,
            'inactiveItems'=>$inactiveItems
        ]);
    }
    
    public function actionCreate()
    {
        $model = new models\Page();

        if(Yii::$app->request->isGet) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        } else {
            $model->filename = $_POST['filename'];
            $model->filecontent = $_POST['filecontent'];
            if($model->save())
            {
                echo 1;
            }
        }
    }
    
    public function actionUpdate() 
    {
        $model = new models\Page(['filename'=> \Yii::$app->request->get('id')]);

        if(Yii::$app->request->isGet) {
            $model->filename = $model->getPageName();
            $model->filecontent = $model->getPageContent();

            return $this->renderAjax('update-form', [
                'model' => $model
            ]);
        } else {
            $model = new models\Page(['filename'=> \Yii::$app->request->get('id')]);
            $model->filename = $_POST['filename'];
            $model->filecontent = $_POST['filecontent'];
            if($model->update())
            {
                return 1;
            }
        }
    }
    
    public function actionDelete()
    {
        $model = new models\Page(['filename'=> \Yii::$app->request->get('id')]);
        if($model->delete())
        {
            return true;
        }
    }
    
    public function actionRemove()
    {
        $model = new models\Page(['filename'=> \Yii::$app->request->get('id')]);
        if($model->remove())
        {
            echo 1;
        }
    }
    
    public function actionRestore()
    {
        $model = new models\Page(['filename'=> \Yii::$app->request->get('id')]);
        if($model->restore())
        {
            echo 1;
        }
    }

    public function actionDropdown()
    {
        $model = new models\Category();

        return $this->render('dropdown', [
            'model' => $model
        ]);
    }

    public function actionSubcat() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = self::getSubCatList($cat_id);
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function getSubCatList($cat_id){
        $posts = models\Subcategory::find()->where('category_id=:category_id', [':category_id' => $cat_id])->asArray()->all();
        foreach ($posts as $i => $m) {
            $data[] = ['id' => $m['id'], 'name' => $m['title']];
        }
        return $data;
    }

    public function actionGetPost(){
        if(isset($_POST['id'])) {
            $sub_cat_id = $_POST['id'];
        }
        $posts = models\Subcategory::find()->where('id=:id', [':id' => $sub_cat_id])->asArray()->all();
        foreach ($posts as $i => $m) {
            $data = ['id' => $m['id'], 'name' => $m['title'], 'content' => $m['content']];
        }
        echo Json::encode($data);
        return;
    }
    
}
