<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "movie_genre_rel".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property integer $genre_id
 *
 * @property Genres $genre
 * @property Movies $movie
 */
class MovieGenreRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movie_genre_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'genre_id'], 'required'],
            [['movie_id', 'genre_id'], 'integer'],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genres::className(), 'targetAttribute' => ['genre_id' => 'id']],
            [['movie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Movies::className(), 'targetAttribute' => ['movie_id' => 'id']],
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
            'genre_id' => 'Genre ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genres::className(), ['id' => 'genre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovie()
    {
        return $this->hasOne(Movies::className(), ['id' => 'movie_id']);
    }
}
