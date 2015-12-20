<?php
namespace app\modules\v1\controllers;

use Yii;
use Exception;
use app\modules\v1\models\Users;
use yii\rest\Controller;
use yii\rest\Serializer;
use app\modules\v1\models\Usertocards;
use app\modules\v1\models\app\modules\v1\models;

class UsertocardsController extends Controller {
	public $modelClass = 'app\modules\v1\models\Usertocards';
	public $serializer = [
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items'
	];
	public function actionList(){
		$data = Yii::$app->request->post();
		if(empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		if(!$user){
			return array (
					'flag' => 0,
					'msg' => 'user not exist!'
			);
		}
		
		return Usertocards::find()->where(['userid'=>$user['id']])->all();
	}
	public function actionCreate(){
		$data = Yii::$app->request->post();
		if(empty($data['phone'])||empty($data['cardnumber'])||empty($data['name'])||empty('idcard')||empty('lphone')||empty('location')){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		if(!$user){
			return array (
				'flag' => 0,
				'msg' => 'user not exist!'
			);
		}
		$model = new Usertocards();
		$model['userid'] = $user['id'];
		foreach (array('cardnumber','name','idcard','lphone','location') as $item){
			$model[$item] = $data[$item];
		}
		if($model->save()){
			return array (
					'flag' => 1,
					'msg' => 'create success!'
			);
		}else{
			return array (
					'flag' => 0,
					'err'=>$model->errors,
					'msg' => 'create failure!'
			);
		}
	}
	
	public function actionDelete(){
		$data = Yii::$app->request->post();
		if(empty($data['phone'])||empty('usertocardid')){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		if(!$user){
			return array (
					'flag' => 0,
					'msg' => 'user not exist!'
			);
		}
		$model = Usertocards::findOne(['id'=>$data['usertocardid']]);
		if(!$model){
			return array (
					'flag' => 0,
					'msg' => 'usertocard not exist!'
			);
		}
		if($model['userid']!=$user['id']){
			return array (
					'flag' => 0,
					'msg' => 'not the owner!'
			);
		}
		if($model->delete()){
			return array (
					'flag' => 1,
					'msg' => 'delete success!'
			);
		}else{
			return array (
					'flag' => 0,
					'msg' => 'delete failure!'
			);
		}
		
	}
}