<?php

use modava\article\ArticleModule;
use yii\helpers\Url;

?>
<ul class="nav nav-tabs nav-sm nav-light mb-10">
    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'article') echo ' active' ?>"
           href="<?= Url::toRoute(['/article']); ?>">
            <i class="ion ion-ios-book"></i><?= Yii::t('backend', 'Article'); ?>
        </a>
    </li>

    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'article-category') echo ' active' ?>"
           href="<?= Url::toRoute(['/article/article-category']); ?>"><i
                    class="ion ion-md-apps"></i><?= Yii::t('backend', 'Article category'); ?></a>
    </li>

    <li class="nav-item mb-5">
        <a class="nav-link link-icon-left<?php if (Yii::$app->controller->id == 'article-type') echo ' active' ?>"
           href="<?= Url::toRoute(['/article/article-type']); ?>"><i
                    class="ion ion-md-transgender"></i><?= Yii::t('backend', 'Article type'); ?></a>
    </li>
</ul>
