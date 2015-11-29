<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "concerns".
 *
 * @property integer $id
 * @property integer $myid
 * @property integer $concernid
 * @property integer $created_at
 * @property Users $concern
 * @property Users $my
 */
class Concerns extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'concerns';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['myid', 'concernid'], 'required'],
            [['myid', 'concernid','created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'myid' => '自己',
            'concernid' => '对方',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConcern()
    {
        return $this->hasOne(Users::className(), ['id' => 'concernid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMy()
    {
        return $this->hasOne(Users::className(), ['id' => 'myid']);
    }
}
