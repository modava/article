<?php

use yii\helpers\Url;
use modava\article\ArticleModule;

?>
<ul class="nav nav-tabs nav-sm nav-light mb-25">
    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'article') echo ' active' ?>"
           href="<?= Url::toRoute(['/article']); ?>">
            <i class="ion ion-ios-book"></i><?= ArticleModule::t('article', 'Article'); ?>
        </a>
    </li>

    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'article-category') echo ' active' ?>"
           href="<?= Url::toRoute(['/article/article-category']); ?>"><i
                    class="ion ion-md-apps"></i><?= ArticleModule::t('article', 'Article category'); ?></a>
    </li>

    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'article-type') echo ' active' ?>"
           href="<?= Url::toRoute(['/article/article-type']); ?>"><i
                    class="ion ion-md-transgender"></i><?= ArticleModule::t('article', 'Article type'); ?></a>
    </li>
</ul>
