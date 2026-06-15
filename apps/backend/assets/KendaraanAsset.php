<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class KendaraanAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/bootstrap.min.css',
        'css/font-awesome-4.7.0/css/font-awesome.min.css',        
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'css/owlcarousel/assets/owl.carousel.min.css'
    ];
    public $js = [
        'css/owlcarousel/owl.carousel.min.js',
        'js/slider.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}