<?php
/**
 * Файл класса типизированной коллекции страниц сайта.
 * @package pages
 */

namespace app\modules\pages\components;

use Yii;
use app\modules\pages\models\Page;
use yii\base\ErrorException;

/**
 * Коллекция объектов представляющих статические страницы
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 * @subpackage components
 */
class PagesCollection extends \SplFixedArray
{
    
    public static function fromArray(array $array, $save_indexes = true) {
        foreach ($array as $object) {
            if(!is_object($object)|| !$object instanceof Page)
            {
                throw new ErrorException(Yii::t('system', 'The array must contain instances of app\modules\page\models\Page'));
            }
        }
        return parent::fromArray($array, false);
    }
    
    /*public function offsetSet($index, Page $newval) {
        parent::offsetSet($index, $newval);
    }*/
}