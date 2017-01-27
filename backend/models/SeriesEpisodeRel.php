<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "series_episode_rel".
 *
 * @property string $id
 * @property string $movie_id
 * @property string $season
 * @property integer $episode
 * @property string $episode_id
 */
class SeriesEpisodeRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'series_episode_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'season', 'episode', 'episode_id'], 'required'],
            [['movie_id', 'season', 'episode', 'episode_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movie_id' => 'Movie ID',
            'season' => 'Season',
            'episode' => 'Episode',
            'episode_id' => 'Episode ID',
        ];
    }

    public function getMovie()
    {
        return $this->hasOne(Movies::className(), ['id' => 'movie_id']);
    }

    public function getMovieName()
    {
        $movie = $this->getMovie();

        return $movie ? $movie->title : '';
    }
}
