<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "zans".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $msgid
 *
 * @property Messages $msg
 * @property Users $user
 */
class Zans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'msgid'], 'required'],
            [['userid', 'msgid'], 'integer']
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
            'msgid' => 'Msgid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMsg()
    {
        return $this->hasOne(Messages::className(), ['id' => 'msgid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
