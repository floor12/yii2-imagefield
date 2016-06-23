<?php

namespace floor12\imagefield;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ImageFieldAsset extends AssetBundle
{

    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $sourcePath = '@vendor/floor12/yii2-imagefield/assets/';
    public $css = [
        'imagefield.css'
    ];
    public $js = [
        'commonimagefield.js',
        'imagefield.js',
        'SimpleAjaxUploader.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
