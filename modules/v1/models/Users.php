<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $phone
 * @property string $pwd
 * @property string $authKey
 * @property integer $fatherid
 * @property integer $directalliancecount
 * @property integer $allalliancecount
 * @property integer $corns
 * @property integer $alliancerewards
 * @property string $nickname
 * @property string $thumb
 * @property string $gender
 * @property string $area
 * @property string $job
 * @property string $hobby
 * @property string $signature
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $channel
 * @property string $platform
 *
 * @property Usertocards[] $usertocards
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'pwd', 'authKey', 'fatherid'], 'required'],
            [['fatherid', 'directalliancecount', 'allalliancecount', 'corns', 'alliancerewards', 'created_at', 'updated_at'], 'integer'],
            [['phone', 'pwd', 'authKey', 'thumb', 'gender', 'area', 'job', 'hobby', 'signature', 'channel', 'platform'], 'string', 'max' => 255],
            [['nickname'], 'string', 'max' => 20],
            [['phone'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'pwd' => 'Pwd',
            'authKey' => 'Auth Key',
            'fatherid' => 'Fatherid',
            'directalliancecount' => 'Directalliancecount',
            'allalliancecount' => 'Allalliancecount',
            'corns' => 'Corns',
            'alliancerewards' => 'Alliancerewards',
            'nickname' => 'Nickname',
            'thumb' => 'Thumb',
            'gender' => 'Gender',
            'area' => 'Area',
            'job' => 'Job',
            'hobby' => 'Hobby',
            'signature' => 'Signature',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'channel' => 'Channel',
            'platform' => 'Platform',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function updateChannel($channel){
    	$this->channel = $channel;
    	$this->save();
    }
    public function getUsertocards()
    {
        return $this->hasMany(Usertocards::className(), ['userid' => 'id']);
    }
}
