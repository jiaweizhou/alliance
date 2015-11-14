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
            [['picture', 'title', 'version'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'picture' => 'Picture',
            'title' => 'Title',
            'version' => 'Version',
            'needed' => 'Needed',
            'remain' => 'Remain',
            'created_at' => 'Created At',
            'date' => 'Date',
            'end_at' => 'End At',
            'islotteried' => 'Islotteried',
            'winneruserid' => 'Winneruserid',
            'winnerrecordid' => 'Winnerrecordid',
            'winnernumber' => 'Winnernumber',
            'foruser' => 'Foruser',
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
