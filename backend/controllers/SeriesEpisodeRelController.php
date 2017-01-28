<?php

namespace backend\controllers;

use backend\models\Movies;
use backend\models\MoviesDP;
use Yii;
use backend\models\SeriesEpisodeRel;
use backend\models\SeriesEpisodeRelSearch;
use backend\controllers\SiteController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * SeriesEpisodeRelController implements the CRUD actions for SeriesEpisodeRel model.
 */
class SeriesEpisodeRelController extends SiteController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all SeriesEpisodeRel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeriesEpisodeRelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SeriesEpisodeRel model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SeriesEpisodeRel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new SeriesEpisodeRel();

        $series = MoviesDP::getMovies(['id', 'title'], ['type' => 'series']);
        $episodes = MoviesDP::getNotBindedSeriesEpisodes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'series' => $series,
                'episodes' => $episodes,
            ]);
        }
    }*/

    /**
     * Updates an existing SeriesEpisodeRel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $series = MoviesDP::getMovies(['id', 'title'], ['type' => 'series']);
        $episodes = MoviesDP::getNotBindedSeriesEpisodes($model->episode_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'series' => $series,
                'episodes' => $episodes,
            ]);
        }
    }

    /**
     * Deletes an existing SeriesEpisodeRel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SeriesEpisodeRel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SeriesEpisodeRel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SeriesEpisodeRel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
