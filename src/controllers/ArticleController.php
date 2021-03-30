<?php

namespace modava\article\controllers;

use backend\components\MyComponent;
use modava\article\components\MyArticleController;
use modava\article\components\MyUpload;
use modava\article\models\Article;
use modava\article\models\ArticleCategory;
use modava\article\models\search\ArticleSearch;
use modava\article\models\table\ActicleCategoryTable;
use modava\article\models\table\ArticleTypeTable;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends MyArticleController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $totalPage = $this->getTotalPage($dataProvider);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalPage' => $totalPage,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save()) {
                    $imageName = null;
                    if ($model->image != "") {
                        $pathImage = FRONTEND_HOST_INFO . $model->image;
                        $path = $this->getUploadDir() . '/web/uploads/article/';
                        foreach (Yii::$app->params['article'] as $key => $value) {
                            $pathSave = $path . $key;
                            if (!file_exists($pathSave) && !is_dir($pathSave)) {
                                mkdir($pathSave);
                            }
                            $imageName = MyUpload::uploadFromOnline($value['width'], $value['height'], $pathImage, $pathSave . '/', $imageName);
                        }

                    }
                    $model->image = $imageName;
                    $model->updateAttributes(['image']);
                    Yii::$app->session->setFlash('toastr-article-view', [
                        'text' => 'Tạo mới thành công',
                        'type' => 'success'
                    ]);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $errors = '';
                foreach ($model->getErrors() as $error) {
                    $errors .= Html::tag('p', $error[0]);
                }
                Yii::$app->session->setFlash('toastr-article-form', [
                    'title' => 'Cập nhật thất bại',
                    'text' => $errors,
                    'type' => 'warning'
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $oldImage = $model->getOldAttribute('image');
                if ($model->save()) {
                    if ($model->getAttribute('image') !== $oldImage) {
                        if ($model->getAttribute('image') != '') {
                            $pathImage = FRONTEND_HOST_INFO . $model->image;
                            $path = $this->getUploadDir() . '/web/uploads/article/';
                            $imageName = null;
                            foreach (Yii::$app->params['article'] as $key => $value) {
                                $pathSave = $path . $key;
                                if (!file_exists($pathSave) && !is_dir($pathSave)) {
                                    mkdir($pathSave);
                                }
                                $resultName = MyUpload::uploadFromOnline($value['width'], $value['height'], $pathImage, $pathSave . '/', $imageName);
                                if ($imageName == null) {
                                    $imageName = $resultName;
                                }
                            }

                            $model->image = $imageName;
                            if ($model->updateAttributes(['image'])) {
                                foreach (Yii::$app->params['article'] as $key => $value) {
                                    $pathSave = $path . $key;
                                    if (file_exists($pathSave . '/' . $oldImage) && !is_dir($pathSave . '/' . $oldImage) && $oldImage != null) {
                                        @unlink($pathSave . '/' . $oldImage);
                                    }

                                }
                            }
                        }
                    }
                    Yii::$app->session->setFlash('toastr-article-view', [
                        'text' => 'Cập nhật thành công',
                        'type' => 'success'
                    ]);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $errors = '';
                foreach ($model->getErrors() as $error) {
                    $errors .= Html::tag('p', $error[0]);
                }
                Yii::$app->session->setFlash('toastr-article-form', [
                    'title' => 'Cập nhật thất bại',
                    'text' => $errors,
                    'type' => 'warning'
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionShowHot()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');

            $model = $this->findModel($id);
            try {
                if ($model->hot == 1) {
                    $model->hot = 0;
                } else {
                    $model->hot = 1;
                }
                if ($model->save()) {
                    echo 1;
                }
            } catch (\yii\db\Exception $exception) {
                echo 0;
            }
        }
    }


    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            if ($model->delete()) {
                Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-index', [
                    'title' => 'Thông báo',
                    'text' => 'Xoá thành công',
                    'type' => 'success'
                ]);
            } else {
                $errors = Html::tag('p', 'Xoá thất bại');
                foreach ($model->getErrors() as $error) {
                    $errors .= Html::tag('p', $error[0]);
                }
                Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-index', [
                    'title' => 'Thông báo',
                    'text' => $errors,
                    'type' => 'warning'
                ]);
            }
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-index', [
                'title' => 'Thông báo',
                'text' => Html::tag('p', 'Xoá thất bại: ' . $ex->getMessage()),
                'type' => 'warning'
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * @param $perpage
     */
    public function actionPerpage($perpage)
    {
        MyComponent::setCookies('pageSize', $perpage);
    }

    /**
     * @param $dataProvider
     * @return float|int
     */
    public function getTotalPage($dataProvider)
    {
        if (MyComponent::hasCookies('pageSize')) {
            $dataProvider->pagination->pageSize = MyComponent::getCookies('pageSize');
        } else {
            $dataProvider->pagination->pageSize = 10;
        }

        $pageSize = $dataProvider->pagination->pageSize;
        $totalCount = $dataProvider->totalCount;
        $totalPage = (($totalCount + $pageSize - 1) / $pageSize);

        return $totalPage;
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }

    public function actionGenerateSlug($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $model = new Article();
            if ($id != null) $model = $this->findModel($id);
            $model->setAttribute('title', Yii::$app->request->post('title'));
            $model->validate();
            return [
                'code' => 200,
                'slug' => $model->slug,
            ];
        }
        return [
            'code' => 403,
            'msg' => 'Không có quyền truy cập chức năng này'
        ];
    }

    public function actionUpdateArticleAlias($article_category_id = null)
    {
        $this->recursiveUpdateArticleCategory($article_category_id);
        return $this->redirect(['index']);
    }

    private function recursiveUpdateArticleCategory($parent_id = null)
    {
        $data = ArticleCategory::find()->where(['parent_id' => $parent_id])->all();
        foreach ($data as $article_category) {
            $article_category->save();
            $this->recursiveUpdateArticle($article_category->primaryKey);
            $this->recursiveUpdateArticleCategory($article_category->primaryKey);
        }
    }

    private function recursiveUpdateArticle($category_id)
    {
        $data = Article::find()->where(['category_id' => $category_id])->all();
        foreach ($data as $article) {
            $article->save();
        }
    }

    public function actionLoadCategoriesByLang($lang = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::map(ActicleCategoryTable::getAllArticleCategory($lang), 'id', 'title');
    }

    public function actionLoadTypesByLang($lang = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::map(ArticleTypeTable::getAllArticleType($lang), 'id', 'title');
    }
}
