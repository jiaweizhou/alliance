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
 * @property string $herphone
 * @property integer $professionid
 * @property string $created_at
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
            [['userid', 'jobproperty', 'degree', 'hidephone', 'professionid','work_at','created_at'], 'integer'],
            [['jobproperty', 'title', 'degree', 'work_at', 'status', 'content'], 'required'],
            [['title', 'status', 'content','herphone'], 'string', 'max' => 255]
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
            'jobproperty' => '工作性质',
            'title' => '标题',
            'degree' => '学历',
            'work_at' => '参加工作时间',
            'status' => '状态',
            'hidephone' => 'Hidephone',
            'content' => '内容',
            'professionid' => '职业',
        		'created_at' => '创建时间',
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
