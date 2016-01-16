<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "daters".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $picture
 * @property integer $sex
 * @property integer $age
 * @property integer $hobbyid
 * @property string $content
 * @property integer $created_at
 * @property double $longitude
 * @property double $latitude
 *
 * @property Hobbies $hobby
 * @property Users $user
 */
class Daters extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'daters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'sex', 'age', 'hobbyid', 'created_at'], 'integer'],
            [['picture', 'hobbyid', 'content'], 'required'],
            [['picture', 'content'], 'string', 'max' => 255]
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
            'picture' => '图片',
            'sex' => '性别',
            'age' => '年龄',
            'hobbyid' => '爱好',
            'content' => '内容',
            'created_at' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHobby()
    {
        return $this->hasOne(Hobbies::className(), ['id' => 'hobbyid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
