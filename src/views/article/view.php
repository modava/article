<?php

use modava\article\models\Article;
use modava\article\ArticleModule;
use modava\article\widgets\NavbarWidgets;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model modava\article\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Article'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php \backend\widgets\ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-view']) ?>
<div class="container-fluid px-xxl-25 px-xl-10">
    <?= NavbarWidgets::widget(); ?>

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                        class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
        </h4>
        <p>
            <a class="btn btn-outline-light btn-sm" href="<?= \yii\helpers\Url::to(['create']); ?>"
               title="<?= Yii::t('backend', 'Create'); ?>">
                <i class="fa fa-plus"></i> <?= Yii::t('backend', 'Create'); ?></a>
            <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'title',
                        [
                            'attribute' => 'category.title',
                            'label' => 'Danh mục',
                        ],
                        [
                            'attribute' => 'type.title',
                            'label' => 'Thể loại',
                        ],
                        'slug',
                        [
                            'attribute' => 'image',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->image == null)
                                    return null;
                                return Html::img(Yii::$app->params['article']['150x150']['folder'] . $model->image, ['width' => 150, 'height' => 150]);
                            }
                        ],
                        'description:html',
                        'content:html',
                        'position',
                        'ads_pixel:html',
                        'ads_session:html',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return Yii::$app->getModule('article')->params['status'][$model->status];
                            }
                        ],
                        'views',
                        [
                            'attribute' => 'language',
                            'value' => function ($model) {
                                if ($model->language == null)
                                    return null;
                                return Yii::$app->params['availableLocales'][$model->language];
                            },
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                        [
                            'attribute' => 'userCreated.userProfile.fullname',
                            'label' => Yii::t('backend', 'Created By')
                        ],
                        [
                            'attribute' => 'userUpdated.userProfile.fullname',
                            'label' => Yii::t('backend', 'Updated By')
                        ],
                    ],
                ]) ?>
            </section>
        </div>
    </div>
</div>
