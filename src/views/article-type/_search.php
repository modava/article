<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modava\article\ArticleModule;

/* @var $this yii\web\View */
/* @var $model modava\article\models\search\ArticleTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'slug') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'ads_pixel') ?>

    <?php // echo $form->field($model, 'ads_session') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(ArticleModule::t('article', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(ArticleModule::t('article', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
