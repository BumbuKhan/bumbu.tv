<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "movie_country_rel".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property integer $country_id
 *
 * @property Countries $country
 * @property Movies $movie
 */
class MovieCountryRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movie_country_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'country_id'], 'required'],
            [['movie_id', 'country_id'], 'integer'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_id' => 'id']],
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
            'country_id' => 'Country ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovie()
    {
        return $this->hasOne(Movies::className(), ['id' => 'movie_id']);
    }
}
