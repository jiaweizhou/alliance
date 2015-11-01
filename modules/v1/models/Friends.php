<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "friends".
 *
 * @property integer $id
 * @property integer $myid
 * @property integer $friendid
 *
 * @property Users $friend
 * @property Users $my
 */
class Friends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['myid', 'friendid'], 'required'],
            [['myid', 'friendid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'myid' => 'Myid',
            'friendid' => 'Friendid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFriend()
    {
        return $this->hasOne(Users::className(), ['id' => 'friendid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMy()
    {
        return $this->hasOne(Users::className(), ['id' => 'myid']);
    }
}
