<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "tbreplys".
 *
 * @property integer $id
 * @property integer $tbmessageid
 * @property string $content
 * @property integer $fromid
 * @property integer $toid
 * @property integer $isread
 * @property integer $created_at
 *
 * @property Users $from
 * @property Tbmessages $tbmessage
 */
class Tbreplys extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbreplys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tbmessageid', 'content', 'fromid', 'toid'], 'required'],
            [['tbmessageid', 'fromid', 'toid', 'isread', 'created_at'], 'integer'],
            [['content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tbmessageid' => '消息ID',
            'content' => '回复内容',
            'fromid' => '回复者',
            'toid' => '回复给',
            'isread' => '是否已读',
            'created_at' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(Users::className(), ['id' => 'fromid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbmessage()
    {
        return $this->hasOne(Tbmessages::className(), ['id' => 'tbmessageid']);
    }
}
