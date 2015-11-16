<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "tbmessages".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $content
 * @property string $picture1
 * @property string $picture2
 * @property string $picture3
 * @property string $picture4
 * @property string $picture5
 * @property string $picture6
 * @property string $picture7
 * @property string $picture8
 * @property string $picture9
 * @property integer $likecount
 * @property integer $replycount
 * @property integer $created_at
 *
 * @property Users $user
 * @property Tbreplys[] $tbreplys
 */
class Tbmessages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbmessages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'content', 'created_at'], 'required'],
            [['userid', 'likecount', 'replycount', 'created_at'], 'integer'],
            [['content', 'picture1', 'picture2', 'picture3', 'picture4', 'picture5', 'picture6', 'picture7', 'picture8', 'picture9'], 'string', 'max' => 255]
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
            'content' => 'Content',
            'picture1' => 'Picture1',
            'picture2' => 'Picture2',
            'picture3' => 'Picture3',
            'picture4' => 'Picture4',
            'picture5' => 'Picture5',
            'picture6' => 'Picture6',
            'picture7' => 'Picture7',
            'picture8' => 'Picture8',
            'picture9' => 'Picture9',
            'likecount' => 'Likecount',
            'replycount' => 'Replycount',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbreplys()
    {
        return $this->hasMany(Tbreplys::className(), ['tbmessageid' => 'id']);
    }
}
