<?php
/**
 * Created by PhpStorm.
 * User: Kem Bi
 * Date: 06-Jul-18
 * Time: 4:42 PM
 */

use modava\article\ArticleModule;

return [
    'defaultLocales' => 'vi',
    'articleName' => 'Article',
    'articleVersion' => '1.0',
    'status' => [
        '0' => Yii::t('backend', 'Tạm ngưng'),
        '1' => Yii::t('backend', 'Hiển thị'),
    ],
];
