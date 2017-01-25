<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "movies".
 *
 * @property integer $id
 * @property string $type
 * @property string $title
 * @property string $description
 * @property string $poster_small
 * @property string $poster_big
 */
class Movies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movies';
    }

    public function scenarios()
    {
        $scenarios = [];
        $scenarios['default'] = ['type'];
        $scenarios['movie_create'] = ['type', 'title', 'description', 'poster_small', 'poster_big'];
        $scenarios['movie_update'] = ['type', 'title', 'description', 'poster_small', 'poster_big'];
        $scenarios['series_episode'] = ['type', 'title', 'description'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'title', 'description', 'poster_small', 'poster_big'], 'required'],
            [['type', 'description'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['poster_small', 'poster_big'], 'image', 'extensions' => ['jpg', 'jpeg']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'title' => 'Title',
            'description' => 'Description',
            'poster_small' => 'Poster Small',
            'poster_big' => 'Poster Big',
        ];
    }
}
