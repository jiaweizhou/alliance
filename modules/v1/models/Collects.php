<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "collects".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $messageid
 * @property integer $created_at
 *
 * @property Messages $message
 * @property Users $user
 */
class Collects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'messageid', 'created_at'], 'required'],
            [['userid', 'messageid', 'created_at'], 'integer']
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
            'messageid' => 'Messageid',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Messages::className(), ['id' => 'messageid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
