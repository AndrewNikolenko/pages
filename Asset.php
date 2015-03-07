<?php

namespace eapanel\pages;

use yii\web\AssetBundle;

/**
 * Widget asset bundle
 */
class Asset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $sourcePath = '@eaPanel/pages/assets';
	/**
	 * @inheritdoc
	 */
	public $css = [
		'pages.css'
	];

	/**
	 * @inheritdoc
	 */
	public $js = [
        'json2.js',
	    'pages.js'
	];

	/**
	 * @inheritdoc
	 */
	public $depends = [
		'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
	];
    
    public function registerAssetFiles($view)
	{
		parent::registerAssetFiles($view);
	}
}