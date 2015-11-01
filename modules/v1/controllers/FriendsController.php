<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\v1\models\Users;
use app\modules\v1\models\Friends;
//use app\modules\v1\models\app\modules\v1\models;

class FriendsController extends Controller
{
    public function actionAdd(){
    	$data = Yii::$app->request->post ();
    	//var_dump($data);
    	if(isset($data['myphone'])&&isset($data['friendphone'])){
    		
    		$u1 = Users::find()->where(['phone'=>$data['myphone']])->one();
    		$u2 = Users::find()->where(['phone'=>$data['friendphone']])->one();
    		
    		if(Friends::findAll(['myid'=>$u1['id'],'friendid'=>$u2['id']]) && Friends::findAll(['myid'=>$u2['id'],'friendid'=>$u1['id']])){
    			return array (
    				'flag' => 1,
    				'msg' => 'is already friend!'
    			);
    		}
    		
    		$fr = new Friends();
    		$fr->myid = $u1['id'];
    		$fr->friendid = $u2['id'];
    		$fr->save();
    		
    		$fr = new Friends();
    		$fr->myid = $u2['id'];
    		$fr->friendid = $u1['id'];
    		$fr->save();
    	
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
