<?php

namespace floor12\imagefield;

use yii\web\AssetBundle;

class SimpleImageFieldAsset extends AssetBundle
{

    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $sourcePath = '@vendor/floor12/yii2-imagefield/assets/';
    public $css = [
        'imagefield.css'
    ];
    public $js = [
        'SimpleAjaxUploader.min.js',
        'commonimagefield.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
