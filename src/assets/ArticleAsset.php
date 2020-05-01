<?php

namespace modava\article\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ArticleAsset extends AssetBundle
{
    public $sourcePath = '@articleweb';
    public $css = [

    ];
    public $js = [

    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
