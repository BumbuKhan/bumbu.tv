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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'poster_small', 'poster_big'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['poster_small'], 'image', 'extensions' => 'png, jpg, jpeg', 'minWidth' => 200, 'maxWidth' => 250, 'minHeight' => 300, 'maxHeight' => 350, 'maxSize' => 1024 * 1024 * 2],
            [['poster_big'], 'image', 'extensions' => 'png, jpg, jpeg', /*'minWidth' => 980, 'maxWidth' => 1200, 'minHeight' => 300, 'maxHeight' => 600, 'maxSize' => 1024 * 1024 * 2*/],
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
