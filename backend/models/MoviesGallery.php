<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "movies_gallery".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property string $img_src
 */
class MoviesGallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movies_gallery';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['movie_edit'] = ['img_src'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_src'], 'required'],
            [['img_src'], 'image', 'extensions' => ['jpg', 'jpeg'], 'maxFiles' => 7],
            [['img_src'], 'image', 'skipOnEmpty' => true, 'extensions' => ['jpg', 'jpeg'], 'maxFiles' => 7, 'on' => 'movie_edit'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'img_src' => 'Gallery images',
        ];
    }

    public function saveData($movie_id, $gal_img)
    {
        // preparing data to batch insert
        $batch_data = [];

        foreach ($gal_img as $img_src) {
            $batch_data[] = ['movie_id' => $movie_id, 'country_id' => $img_src];
        }

        // batch inserting
        $inserted = Yii::$app->db->createCommand()->batchInsert('movies_gallery', ['movie_id', 'img_src'], $batch_data)->execute();
    }

    /**
     * @param $movie_id
     * @return array
     */
    public static function getData($movie_id)
    {
        $sql = "SELECT img_src FROM " . self::tableName() . " WHERE movie_id = :movie_id";

        return Yii::$app->db->createCommand($sql, [':movie_id' => $movie_id])->queryColumn();
    }

    public static function deleteData($id)
    {
        return Yii::$app->db->createCommand()->delete(self::tableName(), ['movie_id' => $id])->execute();
    }
}
