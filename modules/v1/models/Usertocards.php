<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "usertocards".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $cardnumber
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
            [['userid', 'cardnumber'], 'required'],
            [['userid'], 'integer'],
            [['cardnumber'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => ' 用户',
            'cardnumber' => '银行卡号',
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
