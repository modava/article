<?php

use modava\article\Article;
use modava\article\widgets\NavbarWidgets;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modava\article\models\Article */

$this->title = Article::t('article', 'Update : {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Article::t('article', 'Article'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Article::t('article', 'Update');
?>
<div class="container-fluid px-xxl-25 px-xl-10">
    <?= NavbarWidgets::widget(); ?>

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                        class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
        </h4>
        <a class="btn btn-outline-light" href="<?= \yii\helpers\Url::to(['create']); ?>"
           title="<?= Article::t('article', 'Create'); ?>">
            <i class="fa fa-plus"></i> <?= Article::t('article', 'Create'); ?></a>
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
