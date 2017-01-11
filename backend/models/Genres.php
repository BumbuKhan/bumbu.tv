<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "genres".
 *
 * @property string $id
 * @property string $title
 * @property string $add_datetime
 * @property string $is_blocked
 * @property string $is_deleted
 */
class Genres extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'genres';
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[Yii::$app->params['SCENARIO_GENRES_CREATE']] = ['title'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'add_datetime'], 'required'],
            [['add_datetime'], 'safe'],
            [['is_blocked', 'is_deleted'], 'string'],
            [['title'], 'string', 'max' => 255],
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
            'add_datetime' => 'Add Datetime',
            'is_blocked' => 'Blocked',
            'is_deleted' => 'Deleted',
        ];
    }
}
