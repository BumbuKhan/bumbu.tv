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
 * @property string $episode_shot
 * @property string $poster_left
 * @property string $poster_middle
 * @property string $poster_right
 * @property string $gradient_start_color
 * @property string $gradient_end_color
 * @property string $type
 * @property string $level
 * @property string $duration
 * @property string $issue_date
 * @property string $src
 * @property string $trailer_src
 * @property string $ted_original
 * @property string $subtitle
 * @property string $add_datetime
 * @property integer $view_amount
 * @property string $is_blocked
 * @property string $is_deleted
 *
 * @property MovieCountryRel[] $movieCountryRels
 * @property MovieGenreRel[] $movieGenreRels
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'poster_small', 'poster_big', 'episode_shot', 'poster_left', 'poster_middle', 'poster_right', 'gradient_start_color', 'gradient_end_color', 'type', 'level', 'duration', 'issue_date', 'src', 'trailer_src', 'ted_original', 'subtitle', 'add_datetime', 'view_amount'], 'required'],
            [['description', 'type', 'level', 'is_blocked', 'is_deleted'], 'string'],
            [['issue_date', 'add_datetime'], 'safe'],
            [['view_amount'], 'integer'],
            [['title', 'src', 'trailer_src', 'ted_original', 'subtitle'], 'string', 'max' => 255],
            [['poster_small', 'poster_big', 'episode_shot', 'poster_left', 'poster_middle', 'poster_right'], 'string', 'max' => 100],
            [['gradient_start_color', 'gradient_end_color'], 'string', 'max' => 7],
            [['duration'], 'string', 'max' => 8],
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
            'episode_shot' => 'Episode Shot',
            'poster_left' => 'Poster Left',
            'poster_middle' => 'Poster Middle',
            'poster_right' => 'Poster Right',
            'gradient_start_color' => 'Gradient Start Color',
            'gradient_end_color' => 'Gradient End Color',
            'type' => 'Type',
            'level' => 'Level',
            'duration' => 'Duration',
            'issue_date' => 'Issue Date',
            'src' => 'Src',
            'trailer_src' => 'Trailer Src',
            'ted_original' => 'Ted Original',
            'subtitle' => 'Subtitle',
            'add_datetime' => 'Add Datetime',
            'view_amount' => 'View Amount',
            'is_blocked' => 'Blocked',
            'is_deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovieCountryRels()
    {
        return $this->hasMany(MovieCountryRel::className(), ['movie_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovieGenreRels()
    {
        return $this->hasMany(MovieGenreRel::className(), ['movie_id' => 'id']);
    }
}
