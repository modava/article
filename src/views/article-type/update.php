<?php

use modava\article\ArticleModule;
use modava\article\widgets\NavbarWidgets;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modava\article\models\ArticleType */

$this->title = ArticleModule::t('article', 'Update type: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => ArticleModule::t('article', 'Article'), 'url' => ['/article']];
$this->params['breadcrumbs'][] = ['label' => ArticleModule::t('article', 'Article type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ArticleModule::t('article', 'Update');
?>
<div class="container-fluid px-xxl-25 px-xl-10">
    <?= NavbarWidgets::widget(); ?>

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                        class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
        </h4>
        <a class="btn btn-outline-light" href="<?= \yii\helpers\Url::to(['create']); ?>"
           title="<?= ArticleModule::t('article', 'Create'); ?>">
            <i class="fa fa-plus"></i> <?= ArticleModule::t('article', 'Create'); ?></a>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </section>
        </div>
    </div>
</div>