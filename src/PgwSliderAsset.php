<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace floor12\imagefield;

use yii\web\AssetBundle;

class PgwSliderAsset extends AssetBundle {

    public $sourcePath = '@bower';
    public $css = [
        'cropper/dist/pgwslider.min.css',
    ];
    public $js = [
        'cropper/dist/pgwslider.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
