<?php

namespace app\modules\v1\controllers;

use Yii;
use Exception;
use yii\rest\Controller;
//use yii\filters\AccessControl;
use app\modules\v1\models\Tbmessages;
use app\modules\v1\models\Users;
use app\modules\v1\models\Tbzans;
//use app\modules\v1\models\Notify;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Tbreplys;
use app\modules\v1\models\Tblikes;
//use app\modules\v1\models\Appcomments;

// require dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/../vendor/pushserver/sdk.php';
// use PushSDK;
// use app\modules\v1\models\Appl;

class TbusersController extends Controller {
	public $modelClass = 'app\modules\v1\models\Tbmessages';
	public $serializer = [ 
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items' 
	];
	public function actionView(){
		$data=Yii::$app->request->post ();
		if(!(isset($data)&&isset($data['phone'])&&isset($data['herphone']))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$me =Users::findOne(['phone'=>$data['phone']]);
		return (new \yii\db\Query ())
		->select(['users.phone','users.nickname','users.signature','users.friendcount','users.concerncount','if(isnull(concerns.id),0,1) as isconcerned'])
		->from('users')
		->where(['users.phone'=>$data['herphone']])
		->join('LEFT JOIN','concerns','concerns.concernid = users.id and concerns.myid = :id',[':id'=>$me->id])
		->one();
	}

	public function actionHot(){
		return $this->search(Yii::$app->request->post (),1);
	}
	public function actionMyconcerns(){
		return $this->search(Yii::$app->request->post (),2);
	}
	public function actionMyfans(){
		return $this->search(Yii::$app->request->post (),3);
	}
	public function search($data,$type){
		if(!(isset($data)&&isset($data['phone'])&&isset($type))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user =Users::findOne(['phone'=>$data['phone']]);
		$query=(new \yii\db\Query ())
			->select(['users.phone','users.nickname','users.signature','users.concerncount','if(isnull(concerns.id),0,1) as isconcerned'])->from('users');
		switch ($type){
			case 1:
				$query = $query->orderBy('users.concerncount desc')->join('LEFT JOIN','concerns','concerns.concernid = users.id and concerns.myid = :id',[':id'=>$user->id]);
				break;
			case 2:
				$query = $query->orderBy('concerns.created_at desc')->join('INNER JOIN','concerns','concerns.concernid = users.id and concerns.myid = :id',[':id'=>$user->id]);
				break;
			case 3:
				$query = $query->orderBy('concerns.created_at desc')->join('INNER JOIN','concerns c','c.concernid = :id and c.myid = users.id',[':id'=>$user->id])->join('LEFT JOIN','concerns','concerns.concernid = users.id and concerns.myid = :id',[':id'=>$user->id]);
				break;
		}
		$dataProvider=new ActiveDataProvider([
				'query' => $query,
				]);
		return $dataProvider;
	}
}