<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\v1\models\Users;
use app\modules\v1\models\Concerns;
use yii\data\ActiveDataProvider;

//use app\modules\v1\models\app\modules\v1\models;

class ConcernsController extends Controller
{
	public $serializer = [
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items'
	];
	public function actionList(){
		$data = Yii::$app->request->post ();
		if(!(isset($data['phone']))){
			return array (
    				'flag' => 0,
    				'msg' => 'arg not enough!'
    		);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		if(!$user){
			return 	array (
					'flag' => 0,
					'msg' => 'get fail!'
			);
		}
		$query = (new \yii\db\Query ())->select('users.*')->from('concerns')->orderBy('concerns.created_at desc')->join('INNER JOIN','users','concerns.concernid = users.id')->where(['myid'=>$user->id]);
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
		]);
		return $dataProvider;
	}
    public function actionAdd(){
    	$data = Yii::$app->request->post ();
    	//var_dump($data);
    	if(isset($data['myphone'])&&isset($data['concernphone'])){
    		
    		$u1 = Users::find()->where(['phone'=>$data['myphone']])->one();
    		$u2 = Users::find()->where(['phone'=>$data['concernphone']])->one();
    		
    		if(Concerns::findAll(['myid'=>$u1['id'],'concernid'=>$u2['id']]) ){
    			return array (
    				'flag' => 1,
    				'msg' => 'is already concern!'
    			);
    		}
    		
    		$co = new Concerns();
    		$co->myid = $u1['id'];
    		$co->concernid = $u2['id'];
    		$co->created_at = time();
    		$co->save();
    		
    		$u2->concerncount ++;
    		$u2->save();
    		return array (
    				'flag' => 1,
    				'msg' => 'add concern success!'
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
    	if(isset($data['myphone'])&&isset($data['concernphone'])){
    		$u1 = Users::find()->where(['phone'=>$data['myphone']])->one();
    		$u2 = Users::find()->where(['phone'=>$data['concernphone']])->one();
    		
    		if(!Concerns::findAll(['myid'=>$u1['id'],'concernid'=>$u2['id']])){
    			return array (
    					'flag' => 1,
    					'msg' => 'is already not concern!'
    			);
    		}
    		
    		Concerns::deleteAll('myid = :myid and concernid = :concernid',[':myid'=>$u1['id'],':concernid'=>$u2['id']]);
    		$u2->concerncount--;
    		$u2->save();
    		return array (
    				'flag' => 1,
    				'msg' => 'delete concern success!'
    		);
    	}else{
    		return array (
    				'flag' => 0,
    				'msg' => 'arg not enough!'
    		);
    	}
    }
}
