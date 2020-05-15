<?php
/**
 * Created by PhpStorm.
 * User: Kem Bi
 * Date: 06-Jul-18
 * Time: 4:42 PM
 */

use modava\article\Article;

return [
    'articleName' => 'Article',
    'articleVersion' => '1.0',
    'status' => [
        '0' => Article::t('article', 'Tạm ngưng'),
        '1' => Article::t('article', 'Hiển thị'),
    ]
];
