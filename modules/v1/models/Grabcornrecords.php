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
 *
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
            'userid' => 'Userid',
            'grabcornid' => 'Grabcornid',
            'count' => 'Count',
            'numbers' => 'Numbers',
            'type' => 'Type',
            'created_at' => 'Created At',
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
