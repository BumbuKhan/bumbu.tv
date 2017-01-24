<?php

namespace backend\controllers;

use Yii;
use backend\models\Movies;
use backend\models\MoviesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use claviska\SimpleImage;

/**
 * MoviesController implements the CRUD actions for Movies model.
 */
class MoviesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Movies models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MoviesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Movies model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Movies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Movies();

        if ($model->load(Yii::$app->request->post())) {
            $unique_id = uniqid(time()); // Unique ID for file name

            // loading to the temporary folder
            $poster_small = UploadedFile::getInstance($model, 'poster_small');
            $poster_big = UploadedFile::getInstance($model, 'poster_big');

            // picking up file name
            $model->poster_small = 'ps_' . $unique_id . '.' . $poster_small->extension;
            $model->poster_big = 'pb_' . $unique_id . '.' . $poster_big->extension;

            if ($model->save()) {
                try {
                    $image = new SimpleImage();

                    // saving poster_small
                    $image
                        ->fromFile($poster_small->tempName)
                        ->thumbnail(Yii::$app->params['poster_small_width'], Yii::$app->params['poster_small_height'], Yii::$app->params['poster_small_anchor'])
                        ->toFile(Yii::getAlias('@poster_small') . $model->poster_small, 'image/jpeg');

                    // saving poster_big
                    $image
                        ->fromFile($poster_big->tempName)
                        ->thumbnail(Yii::$app->params['poster_big_width'], Yii::$app->params['poster_big_height'], Yii::$app->params['poster_big_anchor'])
                        ->blur(Yii::$app->params['poster_big_blur_filter'], Yii::$app->params['poster_big_blur_filter_passes'])
                        ->darken(Yii::$app->params['poster_big_blur_filter_darken'])
                        ->toFile(Yii::getAlias('@poster_big') . $model->poster_big, 'image/jpeg');

                } catch (Exception $err) {
                    echo $err->getMessage();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Movies model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $small_poster_before_update = $model->poster_small;
        $big_poster_before_update = $model->poster_big;

        if ($model->load(Yii::$app->request->post())) {
            $unique_id = uniqid(time());

            // loading to the temporary folder
            $poster_small = UploadedFile::getInstance($model, 'poster_small');
            $poster_big = UploadedFile::getInstance($model, 'poster_big');

            // picking up file name
            $model->poster_small = 'ps_' . $unique_id . '.' . $poster_small->extension;
            $model->poster_big = 'pb_' . $unique_id . '.' . $poster_big->extension;

            if ($model->save()) {
                Movies::removeFile(Yii::getAlias('@poster_small') . $small_poster_before_update); // deleting old
                Movies::removeFile(Yii::getAlias('@poster_big') . $big_poster_before_update); // deleting old

                try {
                    $image = new SimpleImage();

                    // saving poster_small
                    $image
                        ->fromFile($poster_small->tempName)
                        ->thumbnail(Yii::$app->params['poster_small_width'], Yii::$app->params['poster_small_height'], Yii::$app->params['poster_small_anchor'])
                        ->toFile(Yii::getAlias('@poster_small') . $model->poster_small, 'image/jpeg');

                    // saving poster_big
                    $image
                        ->fromFile($poster_big->tempName)
                        ->thumbnail(Yii::$app->params['poster_big_width'], Yii::$app->params['poster_big_height'], Yii::$app->params['poster_big_anchor'])
                        ->blur(Yii::$app->params['poster_big_blur_filter'], Yii::$app->params['poster_big_blur_filter_passes'])
                        ->darken(Yii::$app->params['poster_big_blur_filter_darken'])
                        ->toFile(Yii::getAlias('@poster_big') . $model->poster_big, 'image/jpeg');

                } catch (Exception $err) {
                    echo $err->getMessage();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Movies model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (!empty($model->poster_small)) {
            Movies::removeFile(Yii::getAlias('@poster_small') . $model->poster_small);
        }

        if (!empty($model->poster_big)) {
            Movies::removeFile(Yii::getAlias('@poster_big') . $model->poster_big);
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Movies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Movies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Movies::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
