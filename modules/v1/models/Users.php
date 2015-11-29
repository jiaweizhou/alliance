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
 * @property string $fatherid
 * @property integer $directalliancecount
 * @property integer $allalliancecount
 * @property integer $corns
 * @property integer $money
 * @property integer $envelope
 * @property integer $cornsforgrab
 * @property integer $alliancerewards
 * @property string $nickname
 * @property string $thumb
 * @property integer $gender
 * @property string $area
 * @property string $job
 * @property string $hobby
 * @property string $signature
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $channel
 * @property string $platform
 * @property integer $isdraw
 * @property integer $friendcount
 * @property integer $concerncount
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
            [['phone'], 'required'],
            [[ 'gender','directalliancecount', 'allalliancecount', 'money','corns','envelope','cornsforgrab', 'alliancerewards', 'created_at', 'updated_at','friendcount','concerncount'], 'integer'],
            [['fatherid','phone', 'pwd', 'authKey', 'thumb', 'area', 'job', 'hobby', 'signature', 'channel', 'platform'], 'string', 'max' => 255],
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
            'phone' => '电话',
            'pwd' => 'Pwd',
            'authKey' => 'Auth Key',
            'fatherid' => '直接上层联盟',
            'directalliancecount' => '直接联盟人数',
            'allalliancecount' => '联盟总人数',
            'corns' => '金币数',
            'alliancerewards' => '联盟奖励',
            'nickname' => '昵称',
            'thumb' => '头像',
            'gender' => '性别',
            'area' => '地区',
            'job' => '工作',
            'hobby' => '爱好',
            'signature' => '签名',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        		'money' => '钱',
        		'isdraw' => '当天领红包次数',
        		'cornsforgrab' =>'夺宝币',
            'channel' => 'Channel',
            'platform' => 'Platform',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function updateChannel($channel){
    	$this->channel = $channel;
    	if($this->save()){
    		return true;
    	}else{
    		return false;
    	}
    }
    public function setFather($fatherphone){
    	//$result=$this->find()->select()->join('INNER JOIN','users u1',['u1.phone'=>$fatherphone])->join('LEFT JOIN','users u2','u3.phone = u1.fatherid')->join('Left JOIN','users u3','u3.phone = u2.fatherid')->one();
    	$result=(new \yii\db\Query())
    		->select('u1.id as f, u2.id as gf ,u3.id as ggf')
    		->from('users u1')->where('u1.phone=:id',[':id'=>$fatherphone])->join('LEFT JOIN','users u2','u2.phone = u1.fatherid')
    		->join('Left JOIN','users u3','u3.phone = u2.fatherid')
    		->one();
    	//var_dump($result);
    	if($result){
    		
    		$this->fatherid = $fatherphone;
    		//var_dump($this);
    		$this->save();
    		//var_dump();
    		Users::updateAllCounters(['directalliancecount'=>1,'allalliancecount'=>1],['id'=>$result['f']]);
    		Users::updateAllCounters(['allalliancecount'=>1],['id'=>$result['gf']]);
    		Users::updateAllCounters(['allalliancecount'=>1],['id'=>$result['ggf']]);
    		return true;
    	}else{
    		return false;
    	}
    }
    public function getUsertocards()
    {
        return $this->hasMany(Usertocards::className(), ['userid' => 'id']);
    }
}
