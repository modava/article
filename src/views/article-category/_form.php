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
$css = <<< CSS
.select2-container input[type=search] {
    width: auto !important;
}
CSS;
$this->registerCss($css);
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
            <div class="col-12">
                <?= $form->field($model, 'key_work')->dropDownList(array_combine($model->key_work ?: [], $model->key_work ?: []), [
                    'class' => 'form-control select2 select2-multiple',
                    'multiple' => 'multiple',
                    'id' => 'key_work'
                ]) ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'parent_id')->dropDownList($result ?: [], ['prompt' => 'Danh mục cha...'])
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

<?php
$this->registerCssFile(Yii::$app->assetManager->publish('@modava-assets/vendors/select2/dist/css/select2.min.css')[1]);
$this->registerJsFile(Yii::$app->assetManager->publish('@modava-assets/vendors/select2/dist/js/select2.full.min.js')[1], ['depends' => [\modava\article\assets\ArticleAsset::class]]);
$script = <<< JS
$(".select2").select2();
$("#key_work").select2({
    tags: true,
    tokenSeparators: [',', ' ']
});

$('body').on('keyup', '.select2-container input[type=search]', function(e){
    var ipt = $(this),
        el = $('#key_work');
    if(e.keyCode === 188){
        var tags = el.val() || [],
            val = ipt.val().replace(',', ''),
            all_val = $.map(el.find('option') ,function(option) {
                return option.value;
            });
        ipt.val(null).focus();
        if(val.trim() === '' || tags.includes(val)) return;
        if(!all_val.includes(val)) {
            all_val.push(val);
            el.append('<option value="'+ val +'">'+ val +'</option>');
        }
        el.find('option[value="'+ val +'"]').prop('selected', 'selected');
        tags.push(val);
        el.select2('destroy').select2().select2('open').val(tags).trigger('change.select2');
    }
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);