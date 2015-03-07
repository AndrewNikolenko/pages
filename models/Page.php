<?php
/**
 * Файл класса модели Page
 * 
 * @package pages
 */

namespace eapanel\pages\models;

use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use dosamigos\transliterator\TransliteratorHelper;

/**
 * Класс представляет статическую страницу
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 * @subpackage models
 */
class Page extends Model{
    
    public $filename;
    
    public $filecontent;
    
    private $isNewPage;
    
    public $viewsPath='@app/views/main';
    
    private $inactiveViewPath='@app/views/inactive';
    
    public function init() {
        $this->isNewPage = true;
    }
    
    public function rules() {
        return[
            ['filename','required'],
            ['filename','uniqueName']
        ];
    }
    
    public function uniqueName()
    {
        
        if($this->exists(Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' )))
        {
            $this->addError('filename',  \Yii::t('validation',"Page {filename} already exists"),['{filename}'=>  Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' )]);
        }
    }

    public static function findOne($filename)
    {
        $file = FileHelper::findFiles(\Yii::getAlias($this->viewsPath), ['only'=>["{$filename}.php"]]);
        return count($file)===0?null:new Page($file);
    }
    
    public function findAll()
    {
        $file = FileHelper::findFiles(\Yii::getAlias($this->viewsPath), [
            'only'=>["*.php"],
            'except'=>["index.php", "create.php", "contact.php", "error.php", "update.php"]
        ]);
        return $file;
    }
    
    public function findAllInactive()
    {
        $file = FileHelper::findFiles(\Yii::getAlias($this->inactiveViewPath), [
            'only'=>["*.php"]
        ]);
        return $file;
    }
    
    public function exists()
    {
        $name = Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' );
        return count(FileHelper::findFiles(\Yii::getAlias($this->viewsPath), ['only'=>["{$name}.php"]]))===0?false:true;
    }

    public function getIsNewPage()
    {
        return $this->isNewPage;
    }
    
    public function save()
    {
        if($this->getIsNewPage())
        {
            if(!$this->exists(Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' )))
            {
                $this->writeForSave();
                return true;
            }
            else
            {
                $this->addError('filename',  \Yii::t('validation',"Page {filename} already exists"),['{filename}'=>  Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' )]);
            }
        }
    }
    
    public function update()
    {
        $rename = rename(
            \Yii::getAlias($this->viewsPath) . "/" . Inflector::slug( TransliteratorHelper::process( \Yii::$app->request->get('id') ), '-', 'en' ) . ".php", 
            \Yii::getAlias($this->viewsPath) . "/" . Inflector::slug( TransliteratorHelper::process( \Yii::$app->request->post()['filename'] ), '-', 'en' ) . ".php"
        );
        $file = \Yii::getAlias($this->viewsPath) . '/' . Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' ) . '.php';
        $data = file(\Yii::getAlias($this->viewsPath) . '/' . Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' ) . '.php');
        $data['2'] = "PageName: $this->filename\n";
        $data['5'] = "PageContent: $this->filecontent\n";
        file_put_contents($file, $data);
        return true;
    }
    
    public function delete()
    {
        rename(\Yii::getAlias($this->viewsPath) . '/' . $this->filename . '.php',\Yii::getAlias($this->inactiveViewPath) . '/' . $this->filename . '.php');
        return true;
    }
    
    public function restore()
    {
        rename(\Yii::getAlias($this->inactiveViewPath) . '/' . $this->filename . '.php', \Yii::getAlias($this->viewsPath) . '/' . $this->filename . '.php');
        return true;
    }
    
    public function remove()
    {
        unlink(\Yii::getAlias($this->inactiveViewPath) . '/' . $this->filename . '.php');
        return true;
    }
    
    public function writeForSave()
    {
        file_put_contents(
            \Yii::getAlias($this->viewsPath) . "/" . Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' ) . ".php", 
            "<?php\n/*\nPageName: $this->filename\n*/\n/*\nPageContent: $this->filecontent\n*/\n?>\n" . '<?php namespace app\modules\eaPanel\components; ?><h1><?php echo $title; ?></h1><div><?php echo $content; ?></div>'
        );
    }
    
    public function getPageName()
    {
        if(file_exists(\Yii::getAlias($this->viewsPath) . '/' . Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' ) . '.php'))
        {
            $file = file(\Yii::getAlias($this->viewsPath) . '/' . Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' ) . '.php');    
        }
        else
        {
            $file = file(\Yii::getAlias($this->inactiveViewPath) . '/' . Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' ) . '.php');
        }
        $title = explode('PageName: ', $file[2]);
        return $title[1];
    }
    
    public function getPageContent()
    {
        $file = file(\Yii::getAlias($this->viewsPath) . '/' . Inflector::slug( TransliteratorHelper::process( $this->filename ), '-', 'en' ) . '.php');
        $content = explode("PageContent: ", $file[5]);
        return $content[1];
    }     
        
}