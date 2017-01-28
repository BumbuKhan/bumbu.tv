<?php

namespace backend\controllers;

use Yii;
use backend\models\Movies;
use backend\models\MoviesSearch;
use backend\models\MoviesDP;
use backend\models\SeriesEpisodeRel;
use backend\controllers\SiteController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * MoviesController implements the CRUD actions for Movies model.
 */
class MoviesController extends SiteController
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
        $series_model = new SeriesEpisodeRel();

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
                case 'episode':
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

        if ($model->load($post) && $series_model->load($post)) {

            if (in_array('poster_small', $model->scenarios()[$model->scenario])) {
                $model->poster_small = UploadedFile::getInstance($model, 'poster_small');
            }

            if (in_array('poster_big', $model->scenarios()[$model->scenario])) {
                $model->poster_big = UploadedFile::getInstance($model, 'poster_big');
            }

            if (in_array('subtitle', $model->scenarios()[$model->scenario])) {
                $model->subtitle = UploadedFile::getInstance($model, 'subtitle');
            }

            if (in_array('series_episode_shot', $model->scenarios()[$model->scenario])) {
                $model->series_episode_shot = UploadedFile::getInstance($model, 'series_episode_shot');
            }

            if (in_array('series_poster_left', $model->scenarios()[$model->scenario])) {
                $model->series_poster_left = UploadedFile::getInstance($model, 'series_poster_left');
            }

            if (in_array('series_poster_right', $model->scenarios()[$model->scenario])) {
                $model->series_poster_right = UploadedFile::getInstance($model, 'series_poster_right');
            }

            if ($model->validate()) {

                // if current scenario euquals to 'series_episode_create' then we should save episode-series bind also
                if ($model->scenario == 'series_episode_create') {
                    if (!$series_model->validate()) {
                        return $this->render('create', [
                            'model' => $model,
                            'series_model' => $series_model,
                            'series' => MoviesDP::getMovies(['id', 'title'], ['type' => 'series']),
                        ]);
                    }
                }

                $unique_id = uniqid(time());

                if (!empty($model->poster_small)) {
                    $file_name = 'ps_' . $unique_id . '.' . $model->poster_small->extension;
                    $model->poster_small->saveAs(Yii::getAlias('@poster_small') . $file_name);
                    $model->poster_small->name = $file_name;
                }

                if (!empty($model->poster_big)) {
                    $file_name = 'pb_' . $unique_id . '.' . $model->poster_big->extension;
                    $model->poster_big->saveAs(Yii::getAlias('@poster_big') . $file_name);
                    $model->poster_big->name = $file_name;
                }

                if (!empty($model->subtitle)) {
                    $file_name = 'st_' . $unique_id . '.' . $model->subtitle->extension;
                    $model->subtitle->saveAs(Yii::getAlias('@subtitles') . $file_name);
                    $model->subtitle->name = $file_name;
                }

                if (!empty($model->series_episode_shot)) {
                    $file_name = 'ep_' . $unique_id . '.' . $model->series_episode_shot->extension;
                    $model->series_episode_shot->saveAs(Yii::getAlias('@episodes') . $file_name);
                    $model->series_episode_shot->name = $file_name;
                }

                if (!empty($model->series_poster_left)) {
                    $file_name = 'spl_' . $unique_id . '.' . $model->series_poster_left->extension;
                    $model->series_poster_left->saveAs(Yii::getAlias('@poster_small') . $file_name);
                    $model->series_poster_left->name = $file_name;
                }

                if (!empty($model->series_poster_right)) {
                    $file_name = 'spr_' . $unique_id . '.' . $model->series_poster_right->extension;
                    $model->series_poster_right->saveAs(Yii::getAlias('@poster_small') . $file_name);
                    $model->series_poster_right->name = $file_name;
                }

                $model->add_datetime = date('Y-m-d H:i:s', time());

                if ($model->save(false)) {
                    if ($model->scenario == 'series_episode_create') {
                        $series_model->episode_id = $model->id;
                        $series_model->save();
                    }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'series_model' => $series_model,
                    'series' => MoviesDP::getMovies(['id', 'title'], ['type' => 'series']),
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'series_model' => $series_model,
            'series' => MoviesDP::getMovies(['id', 'title'], ['type' => 'series']),
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

        $poster_small_before_update = $model->poster_small;
        $poster_big_before_update = $model->poster_big;
        $subtitle_before_update = $model->subtitle;
        $series_episode_shot_before_update = $model->series_episode_shot;
        $series_poster_left_before_update = $model->series_poster_left;
        $series_poster_right_before_update = $model->series_poster_right;

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
                case 'episode':
                    $model->scenario = 'series_episode_update';
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

            if (in_array('poster_small', $model->scenarios()[$model->scenario])) {
                $model->poster_small = UploadedFile::getInstance($model, 'poster_small');
            }

            if (in_array('poster_big', $model->scenarios()[$model->scenario])) {
                $model->poster_big = UploadedFile::getInstance($model, 'poster_big');
            }

            if (in_array('subtitle', $model->scenarios()[$model->scenario])) {
                $model->subtitle = UploadedFile::getInstance($model, 'subtitle');
            }

            if (in_array('series_episode_shot', $model->scenarios()[$model->scenario])) {
                $model->series_episode_shot = UploadedFile::getInstance($model, 'series_episode_shot');
            }

            if (in_array('series_poster_left', $model->scenarios()[$model->scenario])) {
                $model->series_poster_left = UploadedFile::getInstance($model, 'series_poster_left');
            }

            if (in_array('series_poster_right', $model->scenarios()[$model->scenario])) {
                $model->series_poster_right = UploadedFile::getInstance($model, 'series_poster_right');
            }

            if ($model->validate()) {

                $unique_id = uniqid(time());

                if (!empty($model->poster_small) && is_a($model->poster_small, UploadedFile::className())) {
                    $file_name = 'ps_' . $unique_id . '.' . $model->poster_small->extension;
                    self::removeFile(Yii::getAlias('@poster_small') . $poster_small_before_update);
                    $model->poster_small->saveAs(Yii::getAlias('@poster_small') . $file_name);
                    $model->poster_small->name = $file_name;
                } else {
                    $model->poster_small = $poster_small_before_update;
                }

                if (!empty($model->poster_big) && is_a($model->poster_big, UploadedFile::className())) {
                    $file_name = 'pb_' . $unique_id . '.' . $model->poster_big->extension;
                    self::removeFile(Yii::getAlias('@poster_big') . $poster_big_before_update);
                    $model->poster_big->saveAs(Yii::getAlias('@poster_big') . $file_name);
                    $model->poster_big->name = $file_name;
                } else {
                    $model->poster_big = $poster_big_before_update;
                }

                if (!empty($model->subtitle) && is_a($model->subtitle, UploadedFile::className())) {
                    $file_name = 'st_' . $unique_id . '.' . $model->subtitle->extension;
                    self::removeFile(Yii::getAlias('@subtitles') . $subtitle_before_update);
                    $model->subtitle->saveAs(Yii::getAlias('@subtitles') . $file_name);
                    $model->subtitle->name = $file_name;
                } else {
                    $model->subtitle = $subtitle_before_update;
                }

                if (!empty($model->series_episode_shot) && is_a($model->series_episode_shot, UploadedFile::className())) {
                    $file_name = 'ep_' . $unique_id . '.' . $model->series_episode_shot->extension;
                    self::removeFile(Yii::getAlias('@episodes') . $subtitle_before_update);
                    $model->series_episode_shot->saveAs(Yii::getAlias('@episodes') . $file_name);
                    $model->series_episode_shot->name = $file_name;
                } else {
                    $model->series_episode_shot = $series_episode_shot_before_update;
                }

                if (!empty($model->series_poster_left) && is_a($model->series_poster_left, UploadedFile::className())) {
                    $file_name = 'spl_' . $unique_id . '.' . $model->series_poster_left->extension;
                    self::removeFile(Yii::getAlias('@episodes') . $subtitle_before_update);
                    $model->series_poster_left->saveAs(Yii::getAlias('@episodes') . $file_name);
                    $model->series_poster_left->name = $file_name;
                } else {
                    $model->series_poster_left = $series_poster_left_before_update;
                }

                if (!empty($model->series_poster_right) && is_a($model->series_poster_right, UploadedFile::className())) {
                    $file_name = 'spr_' . $unique_id . '.' . $model->series_poster_right->extension;
                    self::removeFile(Yii::getAlias('@episodes') . $subtitle_before_update);
                    $model->series_poster_right->saveAs(Yii::getAlias('@episodes') . $file_name);
                    $model->series_poster_right->name = $file_name;
                } else {
                    $model->series_poster_right = $series_poster_left_before_update;
                }

                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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

        // if type of the removing movie is 'series' then we should remove all episodes stuff binded to it as well
        if ($record->type == 'series') {

            // getting all episodes binded to current series
            $episodes = MoviesDP::getSeriesEpisodes($record->id, ['id', 'subtitle', 'series_episode_shot']);

            $episode_ids = [];

            // deleting media files fro episodes
            if (!empty($episodes)) {
                foreach ($episodes as $episode) {
                    self::removeFile(Yii::getAlias('@subtitles') . $episode['subtitle']);
                    self::removeFile(Yii::getAlias('@episodes') . $episode['series_episode_shot']);

                    $episode_ids[] = $episode['id'];
                }
            }

            // deleting episodes from relation table
            SeriesEpisodeRel::deleteAll(['movie_id' => $record->id]);

            // deleting episodes from main 'movie table'
            Movies::deleteAll(['id' => $episode_ids]);
        }

        // if type of the removing movie is 'episode' then we should remove record from series_episode_rel table also
        if ($record->type == 'episode') {
            SeriesEpisodeRel::find()->where(['episode_id' => $record->id])->one()->delete();
        }

        self::removeFile(Yii::getAlias('@poster_small') . $record->poster_small);
        self::removeFile(Yii::getAlias('@poster_big') . $record->poster_big);
        self::removeFile(Yii::getAlias('@subtitles') . $record->subtitle);
        self::removeFile(Yii::getAlias('@episodes') . $record->series_episode_shot);
        self::removeFile(Yii::getAlias('@poster_small') . $record->series_poster_left);
        self::removeFile(Yii::getAlias('@poster_small') . $record->series_poster_right);


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
