<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "movies".
 *
 * @property integer $id
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
        $scenarios = parent::scenarios();

        // this field are common for all types of movies
        $common_fields = ['title', 'description'];

        $scenarios[Yii::$app->params['SCENARIO_MOVIES_MOVIE_CREATE']] = array_merge($common_fields, ['poster_small', 'poster_big']);
        $scenarios[Yii::$app->params['SCENARIO_MOVIES_MOVIE_EDIT']] = array_merge($common_fields, ['poster_small', 'poster_big']);

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 200],

            // on add
            [['poster_small', 'poster_big'], 'required', 'on' => Yii::$app->params['SCENARIO_MOVIES_MOVIE_CREATE']],
            [['poster_small'], 'image', 'extensions' => 'png, jpg, jpeg', 'minWidth' => 200, 'maxWidth' => 250, 'minHeight' => 300, 'maxHeight' => 350, 'maxSize' => 1024 * 1024 * 2, 'on' => Yii::$app->params['SCENARIO_MOVIES_MOVIE_CREATE']],
            [['poster_big'], 'image', 'extensions' => 'png, jpg, jpeg', 'on' => Yii::$app->params['SCENARIO_MOVIES_MOVIE_CREATE']],

            // on edit
            [['poster_small'], 'image', 'extensions' => 'png, jpg, jpeg', 'minWidth' => 200, 'maxWidth' => 250, 'minHeight' => 300, 'maxHeight' => 350, 'maxSize' => 1024 * 1024 * 2, 'skipOnEmpty' => true, 'on' => Yii::$app->params['SCENARIO_MOVIES_MOVIE_EDIT']],
            [['poster_big'], 'image', 'extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => true, 'on' => Yii::$app->params['SCENARIO_MOVIES_MOVIE_EDIT']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'poster_small' => 'Poster Small',
            'poster_big' => 'Poster Big',
        ];
    }

    /**
     * @param $file
     * @return bool
     */
    public static function removeFile($file)
    {
        return @unlink($file);
    }
}
