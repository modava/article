<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modava\article\ArticleModule;

/* @var $this yii\web\View */
/* @var $model modava\article\models\ArticleCategory */
/* @var $form yii\widgets\ActiveForm */
?>
<?php \backend\widgets\ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
<div class="article-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'language')->dropDownList(Yii::$app->getModule('article')->params['availableLocales'])->label(ArticleModule::t('article', 'Ngôn ngữ')) ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->widget(\modava\tiny\TinyMce::class, [
        'options' => ['rows' => 10],
    ]) ?>

    <?php if (Yii::$app->controller->action->id == 'create')
        $model->status = 1;
    ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(ArticleModule::t('article', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
