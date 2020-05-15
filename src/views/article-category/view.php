<?php

use modava\article\Article;
use modava\article\widgets\NavbarWidgets;
use yii\helpers\Html;
use yii\widgets\DetailView;
use modava\article\models\ArticleCategory;

/* @var $this yii\web\View */
/* @var $model modava\article\models\ArticleCategory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Article::t('article', 'Article'), 'url' => ['/article']];
$this->params['breadcrumbs'][] = ['label' => Article::t('article', 'Article category'), 'url' => ['index']];
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
            <?= Html::a(Article::t('article', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Article::t('article', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Article::t('article', 'Are you sure you want to delete this item?'),
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
                        'slug',
                        'parent_id',
                        'image',
                        'description:html',
                        'position',
                        'ads_pixel:html',
                        'ads_session:html',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return \modava\article\helper\ArticleHelper::GetStatus($model->status);
                            }
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                        [
                            'attribute' => 'created_by',
                            'value' => function ($model) {
                                return ArticleCategory::getUserAsArticleCategory($model->created_by);
                            }
                        ],
                        [
                            'attribute' => 'updated_by',
                            'value' => function ($model) {
                                return ArticleCategory::getUserAsArticleCategory($model->updated_by);
                            }
                        ],
                    ],
                ]) ?>
            </section>
        </div>
    </div>
</div>
