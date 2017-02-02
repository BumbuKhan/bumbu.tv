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
            WHERE m.type = 'episode' 
                AND (s.id IS NULL) " .
            (!empty($include_id) ? "OR m.id = $include_id " : "") .
            "ORDER BY title";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * @param $series_id
     * @param $fields
     * @return array
     */
    public static function getSeriesEpisodes($series_id, $fields)
    {
        $sql = "SELECT m1." . implode(', m1.', $fields) . "
            FROM movies m
                LEFT JOIN series_episode_rel s ON m.id = s.movie_id
                LEFT JOIN movies m1 ON s.episode_id = m1.id
            WHERE m.id = :series_id";

        return Yii::$app->db->createCommand($sql, [':series_id' => $series_id])->queryAll();
    }

    /**
     * @param $movie_id
     * @param $genres_id
     */
    public static function setMovieGenreRel($movie_id, $genres_id)
    {
        // first deleting all records from 'movies_genre_rel' table related to this movie
        self::deleteMovieGenreRel($movie_id);

        // preparing data to batch insert
        $batch_data = [];

        foreach ($genres_id as $genre_id) {
            $batch_data[] = ['movie_id' => $movie_id, 'genre_id' => $genre_id];
        }

        // batch inserting
        $inserted = Yii::$app->db->createCommand()->batchInsert('movies_genre_rel', ['movie_id', 'genre_id'], $batch_data)->execute();
    }

    /**
     * @param $movie_id
     * @return array
     */
    public static function getGenresIdRelatedToMovie($movie_id)
    {
        $sql = "SELECT genre_id FROM movies_genre_rel WHERE movie_id = :movie_id";

        return Yii::$app->db->createCommand($sql, [':movie_id' => $movie_id])->queryColumn();
    }

    /**
     * @param $movie_id
     * @return array
     */
    public static function getMovieGenreRel($movie_id)
    {
        $sql = "SELECT g.id, g.title 
            FROM movies_genre_rel rel
            LEFT JOIN genres g ON rel.genre_id = g.id
            WHERE rel.movie_id = :movie_id";

        return Yii::$app->db->createCommand($sql, [':movie_id' => $movie_id])->queryAll();
    }

    /**
     * @param $movie_id
     * @return int
     */
    public static function deleteMovieGenreRel($movie_id)
    {
        return Yii::$app->db->createCommand()->delete('movies_genre_rel', ['movie_id' => $movie_id])->execute();
    }
}