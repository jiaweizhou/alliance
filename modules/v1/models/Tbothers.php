<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "tbothers".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $title
 * @property string $content
 * @property string $pictures
 * @property integer $created_at
 *
 * @property Users $user
 */
class Tbothers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbothers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'title', 'content', 'created_at'], 'required'],
            [['userid', 'created_at'], 'integer'],
            [['title', 'content'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'content' => 'Content',
            'pictures' => 'Pictures',
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
