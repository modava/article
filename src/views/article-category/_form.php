<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use modava\article\models\table\ActicleCategoryTable;

/* @var $this yii\web\View */
/* @var $model modava\article\models\ArticleCategory */
/* @var $form yii\widgets\ActiveForm */
$mod = new ActicleCategoryTable();
$mod->getCategories(ActicleCategoryTable::getAllArticleCategoryArray(), null, '', $result);
?>
<?php \backend\widgets\ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
<div class="article-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'language')
                ->dropDownList(Yii::$app->params['availableLocales'], ['prompt' => Yii::t('backend', 'Chọn ngôn ngữ...')])
                ->label(Yii::t('backend', 'Ngôn ngữ')) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'parent_id')->dropDownList($result, ['prompt' => 'Danh mục cha...'])
                ->label() ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>

    <?php if (Yii::$app->controller->action->id == 'create')
        $model->status = 1;
    ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
