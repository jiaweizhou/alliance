<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "usertocards".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $cardnumber
 * @property string $name
 * @property string $idcard
 * @property string $phone
 * @property string $location
 *
 * @property Users $user
 */
class Usertocards extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usertocards';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'cardnumber', 'name', 'idcard', 'phone', 'location'], 'required'],
            [['userid'], 'integer'],
            [['cardnumber', 'name', 'idcard', 'phone', 'location'], 'string', 'max' => 255]
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
            'cardnumber' => 'Cardnumber',
            'name' => 'Name',
            'idcard' => 'Idcard',
            'phone' => 'Phone',
            'location' => 'Location',
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
