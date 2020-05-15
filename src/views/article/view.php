<?php

use modava\article\models\Article;
use modava\article\Article as ArticleModule;
use modava\article\widgets\NavbarWidgets;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modava\article\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => ArticleModule::t('article', 'Article'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid px-xxl-25 px-xl-10">
    <?= NavbarWidgets::widget(); ?>

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                        class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
        </h4>
        <p>
            <?= Html::a(ArticleModule::t('article', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(ArticleModule::t('article', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => ArticleModule::t('article', 'Are you sure you want to delete this item?'),
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
                                return Html::img($model->image, ['height' => 150, 'width' => 150]);
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
                                return \modava\article\helper\ArticleHelper::GetStatus($model->status);
                            }
                        ],
                        'views',
                        [
                            'attribute' => 'language',
                            'value' => function ($model) {
                                return Yii::$app->params['availableLocales'][$model->language];
                            }
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                        [
                            'attribute' => 'created_by',
                            'value' => function ($model) {
                                return Article::getUserAsArticle($model->created_by);
                            }
                        ],
                        [
                            'attribute' => 'updated_by',
                            'value' => function ($model) {
                                return Article::getUserAsArticle($model->updated_by);
                            }
                        ],
                    ],
                ]) ?>
            </section>
        </div>
    </div>
</div>