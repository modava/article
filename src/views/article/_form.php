<?php

use modava\article\models\table\ArticleTypeTable;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use modava\article\ArticleModule;
use yii\helpers\ArrayHelper;
use modava\article\models\table\ActicleCategoryTable;

/* @var $this yii\web\View */
/* @var $model modava\article\models\Article */
/* @var $form yii\widgets\ActiveForm */

?>
<?php \backend\widgets\ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
    <div class="article-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <div class="col-4">
                <?= $form->field($model, 'language')
                    ->dropDownList(Yii::$app->params['availableLocales'], ['prompt' => Yii::t('backend', 'Chọn ngôn ngữ...')])
                    ->label(Yii::t('backend', 'Ngôn ngữ')) ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'category_id')
                    ->dropDownList(ArrayHelper::map(ActicleCategoryTable::getAllArticleCategory($model->language), 'id', 'title'), [
                        'prompt' => Yii::t('backend', 'Chọn danh mục...')
                    ])
                    ->label(Yii::t('backend', 'Danh mục')) ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'type_id')
                    ->dropDownList(\yii\helpers\ArrayHelper::map(ArticleTypeTable::getAllArticleType($model->language), 'id', 'title'), [
                        'prompt' => Yii::t('backend', 'Chọn loại...')
                    ])
                    ->label(Yii::t('backend', 'Thể loại')) ?>
            </div>
        </div>

        <?= $form->field($model, 'description')->textarea(['rows'=> '6']); ?>

        <?= $form->field($model, 'content')->widget(\modava\tiny\TinyMce::class, [
            'options' => ['rows' => 15],
            'type' => 'content',
        ]) ?>

        <?php
        if (empty($model->getErrors()))
            $path = Yii::$app->params['article']['150x150']['folder'];
        else
            $path = null;
        echo \modava\tiny\FileManager::widget([
            'model' => $model,
            'attribute' => 'image',
            'path' => $path,
            'label' => Yii::t('backend', 'Hình ảnh') . ': ' . Yii::$app->params['article-size'],
        ]); ?>

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
$urlLoadCategories = Url::toRoute(['load-categories-by-lang']);
$urlLoadTypes = Url::toRoute(['load-types-by-lang']);
$script = <<< JS
function loadDataByLang(url, lang){
    return new Promise((resolve) => {
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            data: {
                lang: lang
            }
        }).done(res => {
            resolve(res);
        }).fail(f => {
            resolve(null);
        });
    });
}
$('body').on('change', '#article-language', async function(){
    var v = $(this).val(),
        categories, types;
    $('#article-category_id, #article-type_id').find('option[value!=""]').remove();
    await loadDataByLang('$urlLoadCategories', v).then(res => categories = res);
    await loadDataByLang('$urlLoadTypes', v).then(res => types = res);
    if(typeof categories === "string"){
        $('#article-category_id').append(categories);
    } else if(typeof categories === "object"){
        Object.keys(categories).forEach(function(k){
            $('#article-category_id').append('<option value="'+ k +'">'+ categories[k] +'</option>');
        });
    }
    if(typeof types === "string"){
        $('#article-type_id').append(types);
    } else if(typeof types === "object"){
        Object.keys(types).forEach(function(k){
            $('#article-type_id').append('<option value="'+ k +'">'+ types[k] +'</option>');
        });
    }
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);
