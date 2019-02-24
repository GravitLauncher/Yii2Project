<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js',
        YII_DEBUG ? 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js' : 'https://cdn.jsdelivr.net/npm/vue',
        'https://unpkg.com/axios/dist/axios.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
