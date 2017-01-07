<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $title
 * @property string $add_datetime
 * @property string $is_blocked
 * @property string $is_deleted
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
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
            [['title'], 'string', 'max' => 60],
            [['title'], 'unique'],
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
