<?php

namespace backend\controllers;

use Yii;
use backend\models\Movies;
use backend\models\MoviesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\controllers\BaseController;
use yii\web\UploadedFile;

/**
 * MoviesController implements the CRUD actions for Movies model.
 */
class MoviesController extends BaseController
{
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

        // getting request
        $request = Yii::$app->request;

        if ($request->isPost) {
            // getting post
            $post = $request->post();

            // getting type of movie
            $movie_type = $post['Movies']['type'];

            // setting scenario up depending on $movie_type
            $scenario_to_setup = '';

            switch ($movie_type) {
                case 'movie':
                    $scenario_to_setup = Yii::$app->params['SCENARIO_MOVIES_MOVIE_CREATE'];
                    break;
                case 'series':
                    $scenario_to_setup = Yii::$app->params['SCENARIO_MOVIES_SERIES_CREATE'];
                    break;
                case 'episode':
                    $scenario_to_setup = Yii::$app->params['SCENARIO_MOVIES_SERIES_EPISODE_CREATE'];
                    break;
                case 'cartoon':
                    $scenario_to_setup = Yii::$app->params['SCENARIO_MOVIES_CARTOON_CREATE'];
                    break;
                case 'ted':
                    $scenario_to_setup = Yii::$app->params['SCENARIO_MOVIES_TED_CREATE'];
                    break;
                default:
                    $scenario_to_setup = Yii::$app->params['SCENARIO_MOVIES_DEFAULT'];
            }

            $model->scenario = $scenario_to_setup;

            // loading post data to the model
            $model->load($post);

            $model->poster_small = UploadedFile::getInstance($model, 'poster_small');
            $model->poster_big = UploadedFile::getInstance($model, 'poster_big');
            $model->episode_shot = UploadedFile::getInstance($model, 'episode_shot');
            $model->poster_left = UploadedFile::getInstance($model, 'poster_left');
            $model->poster_right = UploadedFile::getInstance($model, 'poster_right');
            $model->subtitle = UploadedFile::getInstance($model, 'subtitle');

            if ($model->validate()) {
                $model->add_datetime = date('Y-m-d h:i:s', time());

                $model->save();

                // uploading files...
                $model->upload($movie_type);

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

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
