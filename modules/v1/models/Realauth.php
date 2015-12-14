<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "realauth".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $realname
 * @property string $idcard
 * @property string $picture
 * @property integer $created_at
 *
 * @property Users $user
 */
class Realauth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'realauth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'realname', 'idcard', 'picture', 'created_at'], 'required'],
            [['userid', 'created_at'], 'integer'],
            [['realname', 'idcard', 'picture'], 'string', 'max' => 255]
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
            'realname' => 'Realname',
            'idcard' => 'Idcard',
            'picture' => 'Picture',
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
