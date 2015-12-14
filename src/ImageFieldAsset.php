<?php

namespace floor12\imagefield;

use yii\web\AssetBundle;

class ImageFieldAsset extends AssetBundle {

    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $sourcePath = '@vendor/floor12/yii2-imagefield/assets/';
    public $css = [
        'imagefield.css'
    ];
    public $js = [
        'imagefield.js',
        'uploaderZ.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
