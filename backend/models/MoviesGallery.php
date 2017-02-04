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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_src'], 'required'],
            [['img_src'], 'image', 'extensions' => ['jpg', 'jpeg'], 'maxFiles' => 7],
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
}
