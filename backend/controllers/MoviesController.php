<?php

namespace backend\controllers;

use Yii;
use backend\models\Countries;
use backend\models\Genres;
use backend\models\Movies;
use backend\models\MoviesSearch;
use backend\models\MoviesDP;
use backend\models\MoviesGallery;
use backend\models\SeriesEpisodeRel;
use backend\controllers\SiteController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use claviska\SimpleImage;

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
        $request = Yii::$app->request;

        if ($request->isPost) {
            $img = $request->post('img');

            if (!empty($img) && is_string($img)) {
                // removing from DB
                $is_deleted = MoviesGallery::find()->where(['img_src' => $img])->andWhere(['movie_id' => $id])->limit(1)->one()->delete();

                if ($is_deleted) {
                    // removing from file system
                    MoviesDP::removeFile(Yii::getAlias('@gallery_thumb') . $img);
                }

                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'genres' => ArrayHelper::map(MoviesDP::getMovieGenreRel($id), 'id', 'title'),
            'countries' => ArrayHelper::map(MoviesDP::getMovieCountryRel($id), 'id', 'title'),
            'gallery' => MoviesGallery::getData($id)
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
        $gallery_model = new MoviesGallery();

        $genres_field_has_errors = $countries_field_has_errors = $gallery_field_has_errors = false;
        $checked_genres = $checked_countries = [];

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

            $genres_field_has_errors = (!in_array($model->scenario, ['series_episode_create', 'ted_create', 'default']) && empty($post['genres']) || (!empty($post['genres']) && !is_array($post['genres'])));

            $countries_field_has_errors = (!in_array($model->scenario, ['series_episode_create', 'ted_create', 'default']) && empty($post['countries']) || (!empty($post['countries']) && !is_array($post['countries'])));

            // save checked genres
            $checked_genres = $request->post('genres', []);

            // save checked countries
            $checked_countries = $request->post('countries', []);
        }

        if ($model->load($post) && $series_model->load($post) && $gallery_model->load($post)) {

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

            $gallery_model->img_src = UploadedFile::getInstances($gallery_model, 'img_src');
            $gallery_field_has_errors = (in_array($model->scenario, ['movie_create', 'cartoon_create']) && !$gallery_model->validate());

            if ($model->validate() && !$genres_field_has_errors && !$countries_field_has_errors && !$gallery_field_has_errors) {

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

                $image = new SimpleImage();
                $unique_id = uniqid(time());

                if (!empty($model->poster_small)) {
                    $file_name = 'ps_' . $unique_id . '.' . $model->poster_small->extension;

                    try {
                        if ($model->scenario == 'ted_create') {
                            $img_width = Yii::$app->params['poster_ted_width'];
                            $img_height = Yii::$app->params['poster_ted_height'];
                            $img_anchor = Yii::$app->params['poster_ted_anchor'];
                        } else {
                            $img_width = Yii::$app->params['poster_small_width'];
                            $img_height = Yii::$app->params['poster_small_height'];
                            $img_anchor = Yii::$app->params['poster_small_anchor'];
                        }

                        $image
                            ->fromFile($model->poster_small->tempName)
                            ->thumbnail($img_width, $img_height, $img_anchor)
                            ->toFile(Yii::getAlias('@poster_small') . $file_name, 'image/jpeg');

                    } catch (Exception $err) {
                        echo $err->getMessage();
                    }

                    $model->poster_small->name = $file_name;
                }

                if (!empty($model->poster_big)) {
                    $file_name = 'pb_' . $unique_id . '.' . $model->poster_big->extension;

                    try {
                        $img_width = Yii::$app->params['poster_big_width'];
                        $img_height = Yii::$app->params['poster_big_height'];
                        $img_anchor = Yii::$app->params['poster_big_anchor'];

                        $image
                            ->fromFile($model->poster_big->tempName)
                            ->thumbnail($img_width, $img_height, $img_anchor)
                            ->toFile(Yii::getAlias('@poster_big') . $file_name, 'image/jpeg');

                    } catch (Exception $err) {
                        echo $err->getMessage();
                    }

                    $model->poster_big->name = $file_name;
                }

                if (!empty($model->subtitle)) {
                    $file_name = 'st_' . $unique_id . '.' . $model->subtitle->extension;
                    $model->subtitle->saveAs(Yii::getAlias('@subtitles') . $file_name);
                    $model->subtitle->name = $file_name;
                }

                if (!empty($model->series_episode_shot)) {
                    $file_name = 'ep_' . $unique_id . '.' . $model->series_episode_shot->extension;

                    try {
                        $img_width = Yii::$app->params['series_episode_shot_width'];
                        $img_height = Yii::$app->params['series_episode_shot_height'];
                        $img_anchor = Yii::$app->params['series_episode_shot_anchor'];

                        $image
                            ->fromFile($model->series_episode_shot->tempName)
                            ->thumbnail($img_width, $img_height, $img_anchor)
                            ->toFile(Yii::getAlias('@episodes') . $file_name, 'image/jpeg');

                    } catch (Exception $err) {
                        echo $err->getMessage();
                    }

                    $model->series_episode_shot->name = $file_name;
                }

                if (!empty($model->series_poster_left)) {
                    $file_name = 'spl_' . $unique_id . '.' . $model->series_poster_left->extension;

                    try {
                        $img_width = Yii::$app->params['poster_small_width'];
                        $img_height = Yii::$app->params['poster_small_height'];
                        $img_anchor = Yii::$app->params['poster_small_anchor'];

                        $image
                            ->fromFile($model->series_poster_left->tempName)
                            ->thumbnail($img_width, $img_height, $img_anchor)
                            ->toFile(Yii::getAlias('@poster_small') . $file_name, 'image/jpeg');

                    } catch (Exception $err) {
                        echo $err->getMessage();
                    }

                    $model->series_poster_left->name = $file_name;
                }

                if (!empty($model->series_poster_right)) {
                    $file_name = 'spr_' . $unique_id . '.' . $model->series_poster_right->extension;

                    try {
                        $img_width = Yii::$app->params['poster_small_width'];
                        $img_height = Yii::$app->params['poster_small_height'];
                        $img_anchor = Yii::$app->params['poster_small_anchor'];

                        $image
                            ->fromFile($model->series_poster_right->tempName)
                            ->thumbnail($img_width, $img_height, $img_anchor)
                            ->toFile(Yii::getAlias('@poster_small') . $file_name, 'image/jpeg');

                    } catch (Exception $err) {
                        echo $err->getMessage();
                    }

                    $model->series_poster_right->name = $file_name;
                }

                if (in_array($model->scenario, ['movie_create', 'cartoon_create'])) {
                    $gal_img = [];

                    foreach ($gallery_model->img_src as $k => $img) {
                        $file_name = 'g_' . $unique_id . '_' . $k . '.' . $img->extension;

                        try {
                            $img_width = Yii::$app->params['gal_big_width'];
                            $img_height = Yii::$app->params['gal_big_height'];
                            $img_anchor = Yii::$app->params['gal_big_anchor'];

                            $image
                                ->fromFile($img->tempName)
                                ->thumbnail($img_width, $img_height, $img_anchor)
                                ->toFile(Yii::getAlias('@gallery_big') . $file_name, 'image/jpeg');

                        } catch (Exception $err) {
                            echo $err->getMessage();
                        }

                        try {
                            $img_width = Yii::$app->params['gal_thumb_width'];
                            $img_height = Yii::$app->params['gal_thumb_height'];
                            $img_anchor = Yii::$app->params['gal_thumb_anchor'];

                            $image
                                ->fromFile($img->tempName)
                                ->thumbnail($img_width, $img_height, $img_anchor)
                                ->toFile(Yii::getAlias('@gallery_thumb') . $file_name, 'image/jpeg');

                        } catch (Exception $err) {
                            echo $err->getMessage();
                        }

                        $gal_img[] = $file_name;
                    }
                }

                $model->add_datetime = date('Y-m-d H:i:s', time());

                if ($model->save(false)) {
                    if ($model->scenario == 'series_episode_create') {
                        $series_model->episode_id = $model->id;
                        $series_model->save();
                    }

                    // adding movie-genre & movie-country relations
                    if (!in_array($model->scenario, ['series_episode_create', 'ted_create'])) {
                        MoviesDP::setMovieGenreRel($model->id, $checked_genres);
                        MoviesDP::setMovieCountryRel($model->id, $checked_countries);
                    }

                    // saving gallery
                    if (!empty($gal_img)) {
                        $gallery_model->saveData($model->id, $gal_img);
                    }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'series_model' => $series_model,
                    'gallery_model' => $gallery_model,
                    'series' => MoviesDP::getMovies(['id', 'title'], ['type' => 'series']),
                    'genres' => Genres::find()->orderBy('title')->asArray()->all(),
                    'checked_genres' => $checked_genres,
                    'genres_field_has_errors' => $genres_field_has_errors,
                    'countries' => Countries::find()->orderBy('title')->asArray()->all(),
                    'checked_countries' => $checked_countries,
                    'countries_field_has_errors' => $countries_field_has_errors,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'series_model' => $series_model,
            'gallery_model' => $gallery_model,
            'series' => MoviesDP::getMovies(['id', 'title'], ['type' => 'series']),
            'genres' => Genres::find()->orderBy('title')->asArray()->all(),
            'checked_genres' => $checked_genres,
            'genres_field_has_errors' => $genres_field_has_errors,
            'countries' => Countries::find()->orderBy('title')->asArray()->all(),
            'checked_countries' => $checked_countries,
            'countries_field_has_errors' => $countries_field_has_errors,
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
        $genres_field_has_errors = $countries_field_has_errors = $gallery_field_has_error = false;
        $checked_genres = MoviesDP::getGenresIdRelatedToMovie($id);
        $checked_countries = MoviesDP::getCountriesIdRelatedToMovie($id);

        $poster_small_before_update = $model->poster_small;
        $poster_big_before_update = $model->poster_big;
        $subtitle_before_update = $model->subtitle;
        $series_episode_shot_before_update = $model->series_episode_shot;
        $series_poster_left_before_update = $model->series_poster_left;
        $series_poster_right_before_update = $model->series_poster_right;

        $gallery_model = new MoviesGallery();

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

            $genres_field_has_errors = (!in_array($model->scenario, ['series_episode_create', 'ted_create', 'default']) && empty($post['genres']) || (!empty($post['genres']) && !is_array($post['genres'])));

            $countries_field_has_errors = (!in_array($model->scenario, ['series_episode_create', 'ted_create', 'default']) && empty($post['countries']) || (!empty($post['countries']) && !is_array($post['countries'])));

            // save checked genres
            $checked_genres = $request->post('genres', []);

            // save checked countries
            $checked_countries = $request->post('countries', []);
        }

        if ($model->load($post)) {
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

            // gallery
            if (in_array($model->scenario, ['movie_update', 'cartoon_update'])) {
                $gallery_model->scenario = 'movie_edit';
                $gallery_model->load($post);
                $gallery_model->img_src = UploadedFile::getInstances($gallery_model, 'img_src');

                $gallery_field_has_error = !$gallery_model->validate();
            }

            if ($model->validate() && !$genres_field_has_errors && !$countries_field_has_errors && !$gallery_field_has_error) {

                $image = new SimpleImage();
                $unique_id = uniqid(time());

                if (!empty($model->poster_small) && is_a($model->poster_small, UploadedFile::className())) {
                    $file_name = 'ps_' . $unique_id . '.' . $model->poster_small->extension;
                    MoviesDP::removeFile(Yii::getAlias('@poster_small') . $poster_small_before_update);

                    try {
                        if ($model->scenario == 'ted_create') {
                            $img_width = Yii::$app->params['poster_ted_width'];
                            $img_height = Yii::$app->params['poster_ted_height'];
                            $img_anchor = Yii::$app->params['poster_ted_anchor'];
                        } else {
                            $img_width = Yii::$app->params['poster_small_width'];
                            $img_height = Yii::$app->params['poster_small_height'];
                            $img_anchor = Yii::$app->params['poster_small_anchor'];
                        }

                        $image
                            ->fromFile($model->poster_small->tempName)
                            ->thumbnail($img_width, $img_height, $img_anchor)
                            ->toFile(Yii::getAlias('@poster_small') . $file_name, 'image/jpeg');

                    } catch (Exception $err) {
                        echo $err->getMessage();
                    }

                    $model->poster_small->name = $file_name;
                } else {
                    $model->poster_small = $poster_small_before_update;
                }

                if (!empty($model->poster_big) && is_a($model->poster_big, UploadedFile::className())) {
                    $file_name = 'pb_' . $unique_id . '.' . $model->poster_big->extension;
                    MoviesDP::removeFile(Yii::getAlias('@poster_big') . $poster_big_before_update);

                    try {
                        $img_width = Yii::$app->params['poster_big_width'];
                        $img_height = Yii::$app->params['poster_big_height'];
                        $img_anchor = Yii::$app->params['poster_big_anchor'];

                        $image
                            ->fromFile($model->poster_big->tempName)
                            ->thumbnail($img_width, $img_height, $img_anchor)
                            ->toFile(Yii::getAlias('@poster_big') . $file_name, 'image/jpeg');

                    } catch (Exception $err) {
                        echo $err->getMessage();
                    }

                    $model->poster_big->name = $file_name;
                } else {
                    $model->poster_big = $poster_big_before_update;
                }

                if (!empty($model->subtitle) && is_a($model->subtitle, UploadedFile::className())) {
                    $file_name = 'st_' . $unique_id . '.' . $model->subtitle->extension;
                    MoviesDP::removeFile(Yii::getAlias('@subtitles') . $subtitle_before_update);
                    $model->subtitle->saveAs(Yii::getAlias('@subtitles') . $file_name);
                    $model->subtitle->name = $file_name;
                } else {
                    $model->subtitle = $subtitle_before_update;
                }

                if (!empty($model->series_episode_shot) && is_a($model->series_episode_shot, UploadedFile::className())) {
                    $file_name = 'ep_' . $unique_id . '.' . $model->series_episode_shot->extension;
                    MoviesDP::removeFile(Yii::getAlias('@episodes') . $subtitle_before_update);

                    try {
                        $img_width = Yii::$app->params['series_episode_shot_width'];
                        $img_height = Yii::$app->params['series_episode_shot_height'];
                        $img_anchor = Yii::$app->params['series_episode_shot_anchor'];

                        $image
                            ->fromFile($model->series_episode_shot->tempName)
                            ->thumbnail($img_width, $img_height, $img_anchor)
                            ->toFile(Yii::getAlias('@episodes') . $file_name, 'image/jpeg');

                    } catch (Exception $err) {
                        echo $err->getMessage();
                    }

                    $model->series_episode_shot->name = $file_name;
                } else {
                    $model->series_episode_shot = $series_episode_shot_before_update;
                }

                if (!empty($model->series_poster_left) && is_a($model->series_poster_left, UploadedFile::className())) {
                    $file_name = 'spl_' . $unique_id . '.' . $model->series_poster_left->extension;
                    MoviesDP::removeFile(Yii::getAlias('@episodes') . $subtitle_before_update);

                    try {
                        $img_width = Yii::$app->params['poster_small_width'];
                        $img_height = Yii::$app->params['poster_small_height'];
                        $img_anchor = Yii::$app->params['poster_small_anchor'];

                        $image
                            ->fromFile($model->series_poster_left->tempName)
                            ->thumbnail($img_width, $img_height, $img_anchor)
                            ->toFile(Yii::getAlias('@poster_small') . $file_name, 'image/jpeg');

                    } catch (Exception $err) {
                        echo $err->getMessage();
                    }

                    $model->series_poster_left->name = $file_name;
                } else {
                    $model->series_poster_left = $series_poster_left_before_update;
                }

                if (!empty($model->series_poster_right) && is_a($model->series_poster_right, UploadedFile::className())) {
                    $file_name = 'spr_' . $unique_id . '.' . $model->series_poster_right->extension;
                    MoviesDP::removeFile(Yii::getAlias('@episodes') . $subtitle_before_update);

                    try {
                        $img_width = Yii::$app->params['poster_small_width'];
                        $img_height = Yii::$app->params['poster_small_height'];
                        $img_anchor = Yii::$app->params['poster_small_anchor'];

                        $image
                            ->fromFile($model->series_poster_right->tempName)
                            ->thumbnail($img_width, $img_height, $img_anchor)
                            ->toFile(Yii::getAlias('@poster_small') . $file_name, 'image/jpeg');

                    } catch (Exception $err) {
                        echo $err->getMessage();
                    }

                    $model->series_poster_right->name = $file_name;
                } else {
                    $model->series_poster_right = $series_poster_right_before_update;
                }

                // galleries
                if (!empty($gallery_model->img_src) && is_a($gallery_model->img_src[0], UploadedFile::className()) && in_array($model->scenario, ['movie_update', 'cartoon_update'])) {
                    $gal_img = [];

                    foreach ($gallery_model->img_src as $k => $img) {
                        $file_name = 'g_' . $unique_id . '_' . $k . '.' . $img->extension;

                        try {
                            $img_width = Yii::$app->params['gal_big_width'];
                            $img_height = Yii::$app->params['gal_big_height'];
                            $img_anchor = Yii::$app->params['gal_big_anchor'];

                            $image
                                ->fromFile($img->tempName)
                                ->thumbnail($img_width, $img_height, $img_anchor)
                                ->toFile(Yii::getAlias('@gallery_big') . $file_name, 'image/jpeg');

                        } catch (Exception $err) {
                            echo $err->getMessage();
                        }

                        try {
                            $img_width = Yii::$app->params['gal_thumb_width'];
                            $img_height = Yii::$app->params['gal_thumb_height'];
                            $img_anchor = Yii::$app->params['gal_thumb_anchor'];

                            $image
                                ->fromFile($img->tempName)
                                ->thumbnail($img_width, $img_height, $img_anchor)
                                ->toFile(Yii::getAlias('@gallery_thumb') . $file_name, 'image/jpeg');

                        } catch (Exception $err) {
                            echo $err->getMessage();
                        }

                        $gal_img[] = $file_name;
                    }
                }

                if ($model->save(false)) {

                    // adding movie-genre & movie-country relations
                    if (!in_array($model->scenario, ['series_episode_create', 'ted_create'])) {
                        MoviesDP::setMovieGenreRel($id, $checked_genres);
                        MoviesDP::setMovieCountryRel($model->id, $checked_countries);
                    }

                    // saving gallery
                    if (!empty($gal_img)) {
                        $gallery_model->saveData($id, $gal_img);
                    }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'genres' => Genres::find()->orderBy('title')->asArray()->all(),
                    'checked_genres' => $checked_genres,
                    'genres_field_has_errors' => $genres_field_has_errors,
                    'countries' => Countries::find()->orderBy('title')->asArray()->all(),
                    'checked_countries' => $checked_countries,
                    'countries_field_has_errors' => $countries_field_has_errors,
                    'gallery_model' => $gallery_model,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'genres' => Genres::find()->orderBy('title')->asArray()->all(),
            'checked_genres' => $checked_genres,
            'genres_field_has_errors' => $genres_field_has_errors,
            'countries' => Countries::find()->orderBy('title')->asArray()->all(),
            'checked_countries' => $checked_countries,
            'countries_field_has_errors' => $countries_field_has_errors,
            'gallery_model' => $gallery_model,
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
                    MoviesDP::removeFile(Yii::getAlias('@subtitles') . $episode['subtitle']);
                    MoviesDP::removeFile(Yii::getAlias('@episodes') . $episode['series_episode_shot']);

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

        MoviesDP::removeFile(Yii::getAlias('@poster_small') . $record->poster_small);
        MoviesDP::removeFile(Yii::getAlias('@poster_big') . $record->poster_big);
        MoviesDP::removeFile(Yii::getAlias('@subtitles') . $record->subtitle);
        MoviesDP::removeFile(Yii::getAlias('@episodes') . $record->series_episode_shot);
        MoviesDP::removeFile(Yii::getAlias('@poster_small') . $record->series_poster_left);
        MoviesDP::removeFile(Yii::getAlias('@poster_small') . $record->series_poster_right);

        // deleting genres & countries relation as well
        MoviesDP::deleteMovieGenreRel($id);
        MoviesDP::deleteMovieCountryRel($id);

        // getting gallery's photo
        $gal_photos = MoviesGallery::getData($id);

        if (!empty($gal_photos)) {
            foreach ($gal_photos as $gal_photo) {
                MoviesDP::removeFile(Yii::getAlias('@gallery_thumb') . $gal_photo);
                MoviesDP::removeFile(Yii::getAlias('@gallery_big') . $gal_photo);
            }

            MoviesGallery::deleteData($id);
        }

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
}
