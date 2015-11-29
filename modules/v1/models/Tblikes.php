<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "tblikes".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $tbmessageid
 * @property integer $created_at
 *
 * @property Tbmessages $tbmessage
 * @property Users $user
 */
class Tblikes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblikes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'tbmessageid', 'created_at'], 'required'],
            [['userid', 'tbmessageid', 'created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => '用户',
            'tbmessageid' => '消息ID',
            'created_at' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbmessage()
    {
        return $this->hasOne(Tbmessages::className(), ['id' => 'tbmessageid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
