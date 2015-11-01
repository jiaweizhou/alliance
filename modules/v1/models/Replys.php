<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "replys".
 *
 * @property integer $id
 * @property integer $messageid
 * @property string $content
 * @property integer $fromid
 * @property integer $toid
 * @property integer $isread
 * @property integer $created_at
 *
 * @property Users $from
 * @property Messages $message
 */
class Replys extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'replys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['messageid', 'content', 'fromid', 'toid'], 'required'],
            [['messageid', 'fromid', 'toid', 'isread', 'created_at'], 'integer'],
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
            'messageid' => 'Messageid',
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
    public function getMessage()
    {
        return $this->hasOne(Messages::className(), ['id' => 'messageid']);
    }
}
