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
        'vendors/datatables.net-dt/css/jquery.dataTables.min.css',
        'vendors/bootstrap/dist/css/bootstrap.min.css',
        'css/customArticle.css',
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
