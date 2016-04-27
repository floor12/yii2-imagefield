<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace floor12\imagefield;

use yii\web\AssetBundle;

class LightboxAsset extends AssetBundle {

    public $sourcePath = '@bower';
    public $css = [
        'lightbox2/dist/css/lightbox.min.css',
    ];
    public $js = [
        'lightbox2/dist/js/lightbox.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
