<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "grabcommodityrecords".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $grabcommodityid
 * @property integer $count
 * @property string $numbers
 * @property integer $type
 * @property integer $created_at
 *
 * @property Grabcommodities $grabcommodity
 * @property Users $user
 */
class Grabcommodityrecords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grabcommodityrecords';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'grabcommodityid', 'count', 'type', 'created_at'], 'required'],
            [['userid', 'grabcommodityid', 'count', 'type', 'created_at'], 'integer'],
            //[['numbers'], 'string', 'max' => 255]
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
            'grabcommodityid' => 'Grabcommodityid',
            'count' => 'Count',
            'numbers' => 'Numbers',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrabcommodity()
    {
        return $this->hasOne(Grabcommodities::className(), ['id' => 'grabcommodityid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
