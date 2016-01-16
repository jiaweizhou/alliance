<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "traderecords".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $count
 * @property integer $type
 * @property string $description
 * @property integer $cardid
 * @property integer $created_at
 */
class Traderecords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'traderecords';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'created_at'], 'required'],
            [['userid', 'count', 'type', 'cardid', 'created_at'], 'integer'],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'count' => 'Count',
            'type' => 'Type',
            'description' => 'Description',
            'cardid' => 'Cardid',
            'created_at' => 'Created At',
        ];
    }
}
