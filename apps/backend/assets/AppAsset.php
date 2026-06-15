<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/ionicons/css/ionicons.min.css',
        'css/font-awesome-4.7.0/css/font-awesome.min.css', 
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'css/site.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic',
        'css/bootstrap3-wysihtml5.min.css',
        
    ];
    public $js = [
        'js/adminlte.min.js',
        'js/demo.js',
        'js/bootstrap3-wysihtml5.all.min.js'        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
