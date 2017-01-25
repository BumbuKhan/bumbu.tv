<?php

namespace backend\controllers;

use Yii;
use backend\models\Movies;
use backend\models\MoviesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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
        $request = Yii::$app->request;
        $post = $request->post();

        if ($request->isPost) {
            $type = $post['Movies']['type'];

            switch ($type) {
                case 'movie':
                    $model->scenario = 'movie_create';
                    break;
                case 'series':
                    $model->scenario = 'series_create';
                    break;
                case 'series_episode':
                    $model->scenario = 'series_episode_create';
                    break;
                case 'ted':
                    $model->scenario = 'ted_create';
                    break;
                case 'cartoon':
                    $model->scenario = 'cartoon_create';
                    break;
                default:
                    $model->scenario = 'default';
            }
        }

        if ($model->load($post)) {

            $poster_small = UploadedFile::getInstance($model, 'poster_small');
            $poster_big = UploadedFile::getInstance($model, 'poster_big');

            $unique_id = uniqid(time());

            if (!empty($poster_small)) {
                $model->poster_small = 'ps_' . $unique_id . '.' . $poster_small->extension;
            }

            if (!empty($poster_big)) {
                $model->poster_big = 'pb_' . $unique_id . '.' . $poster_big->extension;
            }

            if ($model->validate()) {

                if (!empty($poster_small)) {
                    $poster_small->saveAs($model->poster_small);
                }

                if (!empty($poster_big)) {
                    $poster_big->saveAs($model->poster_big);
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
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

        $poster_small_before_update = $model->poster_small;
        $poster_big_before_update = $model->poster_big;

        $request = Yii::$app->request;
        $post = $request->post();

        if ($request->isPost) {
            $type = $post['Movies']['type'];

            switch ($type) {
                case 'movie':
                    $model->scenario = 'movie_update';
                    break;
                case 'series':
                    $model->scenario = 'series_update';
                    break;
                case 'series_episode':
                    $model->scenario = 'series_update_create';
                    break;
                case 'ted':
                    $model->scenario = 'ted_update';
                    break;
                case 'cartoon':
                    $model->scenario = 'cartoon_update';
                    break;
                default:
                    $model->scenario = 'default';
            }
        }

        if ($model->load(Yii::$app->request->post())) {

            $poster_small = UploadedFile::getInstance($model, 'poster_small');
            $poster_big = UploadedFile::getInstance($model, 'poster_big');

            $unique_id = uniqid(time());

            if (!empty($poster_small)) {
                self::removeFile($poster_small_before_update);
                $model->poster_small = 'ps_' . $unique_id . '.' . $poster_small->extension;
            } else {
                $model->poster_small = $poster_small_before_update;
            }

            if (!empty($poster_big)) {
                self::removeFile($poster_big_before_update);
                $model->poster_big = 'pb_' . $unique_id . '.' . $poster_big->extension;
            } else {
                $model->poster_big = $poster_big_before_update;
            }

            if ($model->validate()) {

                if (!empty($poster_small)) {
                    $poster_small->saveAs($model->poster_small);
                }

                if (!empty($poster_big)) {
                    $poster_big->saveAs($model->poster_big);
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
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
        $record = $this->findModel($id);

        self::removeFile($record->poster_small);
        self::removeFile($record->poster_big);

        $record->delete();

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

    public static function removeFile($file)
    {
        return @unlink($file);
    }
}
