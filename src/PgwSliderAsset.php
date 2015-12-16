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
        'pgwslider/pgwslider.min.css',
    ];
    public $js = [
        'pgwslider/pgwslider.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
