<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "envelopes".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $count
 * @property integer $type
 * @property integer $created_at
 *
 * @property Users $user
 */
class Envelopes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'envelopes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'created_at'], 'required'],
            [['userid', 'count', 'type', 'created_at'], 'integer']
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
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
