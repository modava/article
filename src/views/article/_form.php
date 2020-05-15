<?php

use modava\article\models\table\ArticleTypeTable;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modava\article\Article;

/* @var $this yii\web\View */
/* @var $model modava\article\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-4">
            <?= $form->field($model, 'category_id')
                ->dropDownList(\yii\helpers\ArrayHelper::map(\modava\article\models\table\ActicleCategoryTable::getAllArticleCategory(), 'id', 'title'))
                ->label('Danh mục') ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'type_id')
                ->dropDownList(\yii\helpers\ArrayHelper::map(ArticleTypeTable::getAllArticleType(), 'id', 'title'))
                ->label('Thể loại') ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'language')->dropDownList(Yii::$app->params['availableLocales'])->label('Ngôn ngữ') ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->widget(\modava\tiny\TinyMce::class, [
        'options' => ['rows' => 6],
    ]) ?>

    <?= $form->field($model, 'content')->widget(\modava\tiny\TinyMce::class, [
        'options' => ['rows' => 15],
        'type' => 'content',
    ]) ?>

    <?= \modava\tiny\FileManager::widget([
        'model' => $model,
        'attribute' => 'image',
        'label' => 'Hình ảnh: 150x150px'
    ]); ?>

    <?php if (Yii::$app->controller->action->id == 'create')
        $model->status = 1;
    ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Article::t('article', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
