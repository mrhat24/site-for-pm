<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        //'css/layout.css',
        'markitup/skins/markitup/style.css',
        'markitup/sets/default/style.css',
        
    ];
    public $js = [
        'markitup/jquery.markitup.js',
        'markitup/sets/default/set.js',
        'js/scripts.js',
        'js/ckeditor/ckeditor.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
