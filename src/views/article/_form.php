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
$mod = new ActicleCategoryTable();
$mod->getCategories(ActicleCategoryTable::getAllArticleCategoryArray(), null, '', $result);
$params = Yii::$app->params;
$css = <<< CSS
.select2-container input[type=search] {
    width: auto !important;
}
CSS;
$this->registerCss($css);
?>
<?php \backend\widgets\ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
    <div class="article-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'title', [
                    'template' => '<div class="counter-content">{label} (<span class="counter">0</span>)</div>{input}{error}',
                ])->textInput([
                    'maxlength' => true,
                    'class' => 'form-control article-title'
                ])->label($model->getAttributeLabel('title'), [
                    'class' => 'control-label custom-counter',
                ]); ?>
            </div>
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'slug', [
                    'options' => [
                        'class' => 'form-group slug-content',
                        'style' => 'display: ' . ($model->title != null || $model->slug != null ? 'block' : 'none')
                    ]
                ])->textInput([
                    'maxlength' => true,
                    'class' => 'form-control slug'
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <?= $form->field($model, 'language')
                    ->dropDownList(Yii::$app->params['availableLocales'], ['prompt' => Yii::t('backend', 'Chọn ngôn ngữ...')])
                    ->label(Yii::t('backend', 'Ngôn ngữ')) ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'category_id')
                    ->dropDownList($result ?: [], [
                        'prompt' => Yii::t('backend', 'Chọn danh mục...')
                    ])
                    ->label(Yii::t('backend', 'Danh mục')) ?>
            </div>
            <div class="col-4">
                <?= $form->field($model, 'type_id')
                    ->dropDownList(\yii\helpers\ArrayHelper::map(ArticleTypeTable::getAllArticleType($model->language) ?: [], 'id', 'title'), [
                        'prompt' => Yii::t('backend', 'Chọn loại...')
                    ])
                    ->label(Yii::t('backend', 'Thể loại')) ?>
            </div>
        </div>

        <?= $form->field($model, 'description', [
            'template' => '<div class="counter-content">{label} (<span class="counter">0</span>)</div>{input}{error}',
        ])->textarea([
            'rows' => '6',
        ])->label($model->getAttributeLabel('description'), [
            'class' => 'control-label custom-counter',
        ]); ?>

        <?= $form->field($model, 'content')->widget(\modava\tiny\TinyMce::class, [
            'options' => ['rows' => 15],
            'type' => 'content',
        ]) ?>
        <div class="row">
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'priority')->input('number', [
                    'max' => 1,
                    'min' => 0,
                    'step' => 0.1
                ]) ?>
            </div>
        </div>
        <?= $form->field($model, 'tags')->dropDownList(array_combine($model->tags ?: [], $model->tags ?: []), [
            'class' => 'form-control select2 select2-multiple',
            'multiple' => 'multiple',
            'id' => 'input_tags'
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
$this->registerCssFile(Yii::$app->assetManager->publish('@modava-assets/vendors/select2/dist/css/select2.min.css')[1]);
$this->registerJsFile(Yii::$app->assetManager->publish('@modava-assets/vendors/select2/dist/js/select2.full.min.js')[1], ['depends' => [\modava\article\assets\ArticleAsset::class]]);
$urlLoadCategories = Url::toRoute(['load-categories-by-lang']);
$urlLoadTypes = Url::toRoute(['load-types-by-lang']);
$urlGetSlug = Url::toRoute(['generate-slug', 'id' => $model->primaryKey]);
$script = <<< JS
$(".select2").select2();
$("#input_tags").select2({
    tags: true,
    tokenSeparators: [',', ' ']
});
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
$('body .custom-counter').each(function(){
    var label = $(this),
        ipt = label.attr('ipt-counter') || null,
        content = label.closest('.counter-content').find('.counter') || null;
    if(ipt === null || $(ipt).length <= 0) ipt = $('#'+ label.attr('for'));
    if(content.length <= 0) return;
    ipt.on('change paste keyup', function(){
        content.text($(this).val().length);
    });
});
$('body').on('keyup', '.select2-container input[type=search]', function(e){
    var ipt = $(this),
        el = $('#input_tags');
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
}).on('change paste', '.article-title', function(){
    var title = $(this).val() || null;
    if(title !== null){
        $.ajax({
            type: 'POST',
            url: '$urlGetSlug',
            dataType: 'json',
            data: {
                title: title
            }
        }).done(res => {
            if(res.code === 200){
                $('.slug').val(res.slug);
            } else {
                console.log(res.msg);
            }
        }).fail(f => {
            console.log('Get slug failed', f);
        });
        $('.slug-content').slideDown();
    } else {
        $('.slug-content').slideUp();
    }
}).on('change', '#article-language', async function(){
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