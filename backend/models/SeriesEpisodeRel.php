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
 *
 * @property Movies $movie
 * @property Movies $episode0
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
            [['movie_id', 'season', 'episode'], 'required'],
            [['movie_id', 'season', 'episode'], 'integer'],
            [['movie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Movies::className(), 'targetAttribute' => ['movie_id' => 'id']],
            //[['episode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Movies::className(), 'targetAttribute' => ['episode_id' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovie()
    {
        return $this->hasOne(Movies::className(), ['id' => 'movie_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEpisode0()
    {
        return $this->hasOne(Movies::className(), ['id' => 'episode_id']);
    }
}
