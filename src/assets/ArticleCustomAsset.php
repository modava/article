<?php

namespace modava\article\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ArticleCustomAsset extends AssetBundle
{
    public $sourcePath = '@articleweb';
    public $css = [
        'css/customArticle.css',
    ];
    public $js = [
        'js/customArticle.js'
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
