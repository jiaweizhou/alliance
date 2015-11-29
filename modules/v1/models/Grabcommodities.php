<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "grabcommodities".
 *
 * @property integer $id
 * @property string $picture
 * @property string $title
 * @property string $version
 * @property integer $needed
 * @property integer $remain
 * @property integer $created_at
 * @property integer $date
 * @property integer $end_at
 * @property integer $islotteried
 * @property integer $winneruserid
 * @property integer $winnerrecordid
 * @property integer $winnernumber
 * @property integer $foruser
 * @property integer $kind
 * @property string $pictures
 * @property integer $worth
 * @property integer $isgot
 * @property string $details
 * 
 * @property Grabcommodityrecords[] $grabcommodityrecords
 */
class Grabcommodities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grabcommodities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'version', 'needed', 'remain', 'created_at', 'date', 'end_at','kind'], 'required'],
            [['needed', 'remain', 'created_at', 'date', 'end_at', 'islotteried', 'winneruserid', 'winnerrecordid', 'winnernumber', 'foruser','kind'], 'integer'],
            [['picture', 'title', 'version'], 'string', 'max' => 255],
        	[['pictures','details'], 'string', 'max' => 2550]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'picture' => '缩略图',
            'title' => '标题',
            'version' => '期数',
            'needed' => '总人次',
            'remain' => '剩余人次',
            'created_at' => '创建时间',
            'date' => '开始时间',
            'end_at' => '结束时间',
            'islotteried' => '是否开奖',
            'winneruserid' => '获奖者',
            'winnerrecordid' => '获奖者对应记录',
            'winnernumber' => '获奖号码',
            'foruser' => '为某一用户',
        		'isgot' => '是否被领取',
        		'worth' => '总价值',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrabcommodityrecords()
    {
        return $this->hasMany(Grabcommodityrecords::className(), ['grabcommodityid' => 'id']);
    }
}
