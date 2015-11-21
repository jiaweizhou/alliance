<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "tbmessages".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $title
 * @property string $content
 * @property string $pictures
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
            [['userid', 'content',  'title', 'created_at'], 'required'],
            [['userid', 'likecount', 'replycount', 'created_at'], 'integer'],
            [['content','title'], 'string', 'max' => 255],
        	[['pictures'], 'string', 'max' => 2550]
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
            'pictures' => 'Pictures',
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
