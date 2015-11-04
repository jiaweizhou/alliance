<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "applyjobs".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $jobproperty
 * @property string $title
 * @property integer $degree
 * @property string $work_at
 * @property string $status
 * @property integer $hidephone
 * @property string $content
 * @property integer $professionid
 * @property string $create_at
 *
 * @property Professions $profession
 * @property Users $user
 */
class Applyjobs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applyjobs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'jobproperty', 'degree', 'hidephone', 'professionid','work_at','create_at'], 'integer'],
            [['jobproperty', 'title', 'degree', 'work_at', 'status', 'content'], 'required'],
            [['title', 'status', 'content'], 'string', 'max' => 255]
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
            'jobproperty' => 'Jobproperty',
            'title' => 'Title',
            'degree' => 'Degree',
            'work_at' => 'Work At',
            'status' => 'Status',
            'hidephone' => 'Hidephone',
            'content' => 'Content',
            'professionid' => 'Professionid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfession()
    {
        return $this->hasOne(Professions::className(), ['id' => 'professionid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
