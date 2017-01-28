<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class MoviesDP extends Model
{
    /**
     * @param $fields
     * @param $conditions
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getMovies($fields, $conditions)
    {
        return \backend\models\Movies::find()
            ->select($fields)
            ->where($conditions)
            ->orderBy('title')
            ->asArray()
            ->all();
    }

    /**
     * @param null $include_id
     * @return array
     */
    public static function getNotBindedSeriesEpisodes($include_id = null)
    {
        $sql = "SELECT m.id, m.title
            FROM movies m
                LEFT JOIN series_episode_rel s ON m.id = s.episode_id
            WHERE m.type = 'series_episode' 
                AND (s.id IS NULL) " .
            (!empty($include_id) ? "OR m.id = $include_id " : "") .
            "ORDER BY title";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }
}