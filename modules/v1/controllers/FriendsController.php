<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\v1\models\Users;
use app\modules\v1\models\Friends;
use app\modules\v1\models\Easeapi;
//use app\modules\v1\models\app\modules\v1\models;

class FriendsController extends Controller
{
	public $serializer = [
	'class' => 'yii\rest\Serializer',
	'collectionEnvelope' => 'items'
			];
    public function actionApprove(){
    	$data = Yii::$app->request->post ();
    	//var_dump($data);
    	if(isset($data['myphone'])&&isset($data['friendphone'])){
    		
    		$u1 = Users::find()->where(['phone'=>$data['myphone']])->one();
    		$u2 = Users::find()->where(['phone'=>$data['friendphone']])->one();
    		
    		$re1 = Friends::findOne(['myid'=>$u1['id'],'friendid'=>$u2['id']]);
    		$re2 = Friends::findOne(['myid'=>$u2['id'],'friendid'=>$u1['id']]);
    		if($re1 && $re2){
    			//$easeclient=new Easeapi('YXA6halokJDEEeWMRgvYONLZPQ','YXA6pswnZbss8mj351XE3oxuRYm6cek','13022660999','allpeopleleague','file');
    			//$result=json_decode($easeclient->curl('/users/' . $u1->id . '/contacts/users/' . $u2->id ,'' , true));
    			return array (
    				'flag' => 1,
    				'msg' => 'is already friend!'
    			);
    		}else if($re1 || $re2){
    			foreach ($re1 as $re){
    				$re->delete();
    			}
    			foreach ($re2 as $re){
    				$re->delete();
    			}
    		}
    		
    		$fr1 = new Friends();
    		$fr1->myid = $u1['id'];
    		$fr1->friendid = $u2['id'];
    		$fr1->save();
    		
    		$fr2 = new Friends();
    		$fr2->myid = $u2['id'];
    		$fr2->friendid = $u1['id'];
    		$fr2->save();
    		
    		
    		$easeclient=new Easeapi('YXA6halokJDEEeWMRgvYONLZPQ','YXA6pswnZbss8mj351XE3oxuRYm6cek','13022660999','allpeopleleague','file');
    		$result=json_decode($easeclient->curl('/users/' . $u1->id . '/contacts/users/' . $u2->id ,'' ),true);
    		//return $result;
    		if(isset($result['error'])){
    			$fr1->delete();
    			$fr2->deletw();
    			return array (
    					'error'=>$result,
    					'flag' => 0,
    					'msg' => 'add error!'
    			);
    		}
    		return array (
    				'flag' => 1,
    				'msg' => 'add friend success!'
    		);
    	}else{
    		return array (
    				'flag' => 0,
    				'msg' => 'arg not enough!'
    		);
    	}
    	
    }
    
    public function actionDelete(){
    	$data = Yii::$app->request->post ();
    	if(isset($data['myphone'])&&isset($data['friendphone'])){
    		$u1 = Users::find()->where(['phone'=>$data['myphone']])->one();
    		$u2 = Users::find()->where(['phone'=>$data['friendphone']])->one();
    		
    		if(!Friends::findAll(['myid'=>$u1['id'],'friendid'=>$u2['id']]) && !Friends::findAll(['myid'=>$u2['id'],'friendid'=>$u1['id']])){
    			return array (
    					'flag' => 1,
    					'msg' => 'is already not friend!'
    			);
    		}
    		
    		Friends::deleteAll('myid = :myid and friendid = :friendid or myid = :friendid and friendid = :myid',[':myid'=>$u1['id'],':friendid'=>$u2['id']]);
    		$easeclient=new Easeapi('YXA6halokJDEEeWMRgvYONLZPQ','YXA6pswnZbss8mj351XE3oxuRYm6cek','13022660999','allpeopleleague','file');
    		$result=json_decode($easeclient->curl('/users/' . $u1->id . '/contacts/users/' . $u2->id ,'' ,'DELETE'),true);
    		return array (
    				'flag' => 1,
    				'msg' => 'delete friend success!'
    		);
    	}else{
    		return array (
    				'flag' => 0,
    				'msg' => 'arg not enough!'
    		);
    	}
    }
}
