<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modava\article\ArticleModule;
use modava\article\models\table\ActicleCategoryTable;

/* @var $this yii\web\View */
/* @var $model modava\article\models\search\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */

$params = Yii::$app->getModule('article')->params['class_button_search'];
$mod = new ActicleCategoryTable();
$mod->getCategories(ActicleCategoryTable::getAllArticleCategoryArray(), null, '', $result);
?>

<div class="article-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'form-search'
        ],
    ]); ?>
    <section class="hk-sec-wrapper p-1">
        <div class="row collapse show save-state-search" data-search-panel="article-search-panel" id="search-panel">
            <div class="col-md-3 col-sm-4 col-lg-3">
                <?= $form->field($model, 'title', [
                    'template' => '{label}<div class="input-group">{input}<button type="button" class="btn btn-light clear-value"><span class="fa fa-times"></span></button></div>{error}{hint}'
                ])->textInput([
                    'placeholder' => $model->getAttributeLabel('title')
                ]) ?>
            </div>
            <div class="col-md-3 col-sm-4 col-lg-3">
                <?= $form->field($model, 'category_id', [
                    'template' => '{label}<div class="input-group">{input}<button type="button" class="btn btn-light clear-value"><span class="fa fa-times"></span></button></div>{error}{hint}'
                ])->dropDownList($result ?: [], [
                    'prompt' => $model->getAttributeLabel('category_id')
                ]) ?>
            </div>
        </div>
        <?= $form->field($model, 'btn_search', ['options' => ['tag' => false]])->hiddenInput(['class' => 'btn_search'])->label(false) ?>
        <div class="row">
            <div class="col-12 d-flex">
                <?= Html::submitButton(Yii::t('backend', 'Search'), [
                    'class' => 'btn-action-search btn btn-sm mr-1 ' . ($model->btn_search == 1 ? $params['active'] : $params['inactive']),
                    'data-btn' => 1
                ]) ?>
                <?= Html::a('Mặc định', ['index'], ['class' => 'btn btn-sm mr-1 ' . ($model->btn_search == 2 ? $params['active'] : $params['inactive'])]) ?>
                <button class="btn btn-primary btn-sm btn-hide-search ml-auto" data-toggle="collapse"
                        data-target="#search-panel"
                        aria-expanded="false" aria-controls="search-panel" type="button"><?= Yii::t('backend',
                        'Ẩn tìm kiếm') ?></button>
            </div>
        </div>
    </section>
    <?php ActiveForm::end(); ?>
</div>
