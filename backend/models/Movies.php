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
 * @property integer $duration
 * @property string $src
 * @property string $trailer
 * @property string $ted_original
 * @property string $subtitle
 * @property string $series_episode_shot
 * @property string $series_poster_left
 * @property string $series_poster_right
 * @property string $series_poster_gradient_start
 * @property string $series_poster_gradient_end
 * @property string $issue_date
 * @property string $add_datetime
 * @property integer $view_amount
 * @property string $is_blocked
 * @property string $is_deleted
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

        $scenarios['movie_create'] = $scenarios['movie_update'] = [
            'type',
            'title',
            'description',
            'poster_small',
            'poster_big',
            'duration',
            'src',
            'trailer',
            'subtitle',
            'issue_date',
        ];
        $scenarios['series_create'] = $scenarios['series_update'] = [
            'type',
            'title',
            'description',
            'poster_small',
            'poster_big',
            'trailer',
            'series_poster_left',
            'series_poster_right',
            'series_poster_gradient_start',
            'series_poster_gradient_end',
        ];
        $scenarios['series_episode_create'] = $scenarios['series_episode_update'] = [
            'type',
            'title',
            'description',
            'duration',
            'src',
            'subtitle',
            'series_episode_shot',
            'issue_date',
        ];
        $scenarios['ted_create'] = $scenarios['ted_update'] = [
            'type',
            'title',
            'description',
            'poster_small',
            'duration',
            'src',
            'ted_original',
            'subtitle',
            'issue_date',
        ];
        $scenarios['cartoon_create'] = $scenarios['cartoon_update'] = [
            'type',
            'title',
            'description',
            'poster_small',
            'poster_big',
            'duration',
            'src',
            'trailer',
            'subtitle',
            'issue_date',
        ];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'title', 'description', 'duration', 'src', 'trailer', 'ted_original', 'series_poster_gradient_start', 'series_poster_gradient_end', 'issue_date'], 'required'],
            [['type', 'description', 'src', 'trailer', 'ted_original'], 'string'],
            [['title'], 'string', 'max' => 20],
            [['series_poster_gradient_start', 'series_poster_gradient_end'], 'string'],
            [['poster_small', 'poster_big', 'series_episode_shot', 'series_poster_left', 'series_poster_right'], 'image', 'extensions' => ['jpg', 'jpeg']],
            [['subtitle'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => ['vtt', 'srt']],
            [['duration'], 'integer', 'max' => 999],

            [['subtitle'], 'required', 'on' => ['movie_create', 'series_episode_create', 'ted_create', 'cartoon_create']],
            [['poster_small', 'poster_big'], 'required', 'on' => ['movie_create', 'series_create', 'cartoon_create']],
            [['poster_small'], 'required', 'on' => ['ted_create']],
            [['series_episode_shot'], 'required', 'on' => ['series_episode_create']],
            [['series_poster_left', 'series_poster_right'], 'required', 'on' => ['series_create']],
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
            'duration' => 'Duration',
            'src' => 'Src',
            'trailer' => 'Trailer',
            'ted_original' => 'Ted Original',
            'subtitle' => 'Subtitle',
            'series_episode_shot' => 'Series Episode Shot',
            'series_poster_left' => 'Series Poster Left',
            'series_poster_right' => 'Series Poster Right',
            'series_poster_gradient_start' => 'Series Poster Gradient Start',
            'series_poster_gradient_end' => 'Series Poster Gradient End',
            'issue_date' => 'Issue Date',
            'add_datetime' => 'Add Datetime',
            'view_amount' => 'View Amount',
            'is_blocked' => 'Is Blocked',
            'is_deleted' => 'Is Deleted',
        ];
    }
}