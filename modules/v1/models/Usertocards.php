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
 * @property string $lphone
 * @property string $location
 * @property string $bankname
 * @property string $bankcode
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
            [['userid', 'cardnumber', 'name', 'idcard', 'lphone', 'location','bankname','bankcode'], 'required'],
            [['userid'], 'integer'],
            [['cardnumber', 'name', 'idcard', 'lphone', 'location','bankname','bankcode'], 'string', 'max' => 255]
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
            'lphone' => 'Lphone',
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
