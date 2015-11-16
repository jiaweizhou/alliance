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
            'tbmessageid' => 'Tbmessageid',
            'content' => 'Content',
            'fromid' => 'Fromid',
            'toid' => 'Toid',
            'isread' => 'Isread',
            'created_at' => 'Created At',
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
