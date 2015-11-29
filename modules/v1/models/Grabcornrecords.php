<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "grabcornrecords".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $grabcornid
 * @property integer $count
 * @property string $numbers
 * @property integer $type
 * @property integer $created_at
 * @property integer $isgotback
 * @property Grabcorns $grabcorn
 * @property Users $user
 */
class Grabcornrecords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grabcornrecords';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'grabcornid', 'count', 'type', 'created_at'], 'required'],
            [['userid', 'grabcornid', 'count', 'type', 'created_at'], 'integer'],
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
            'userid' => '用户',
            'grabcornid' => '夺金id',
            'count' => '购买数量',
            'numbers' => '开奖号',
            'type' => '支付方式',
            'created_at' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrabcorn()
    {
        return $this->hasOne(Grabcorns::className(), ['id' => 'grabcornid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
