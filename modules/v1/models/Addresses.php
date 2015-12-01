<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $address
 * @property string $name
 * @property string $aphone
 * @property string $postcode
 * @property integer $created_at
 * @property integer $isdefault
 *
 * @property Users $user
 */
class Addresses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'address', 'name', 'aphone', 'created_at'], 'required'],
            [['userid', 'created_at','isdefault'], 'integer'],
            [['address', 'name', 'aphone', 'postcode'], 'string', 'max' => 255]
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
            'address' => 'Address',
            'name' => 'Name',
            'aphone' => 'Phone',
            'postcode' => 'Postcode',
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
