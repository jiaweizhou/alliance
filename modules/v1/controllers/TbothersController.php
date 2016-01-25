<?php

namespace app\modules\v1\controllers;

use Yii;
use Exception;
use yii\rest\Controller;
use app\modules\v1\models\Tbothers;
use app\modules\v1\models\Users;
use yii\data\ActiveDataProvider;

class TbothersController extends Controller {
	public $modelClass = 'app\modules\v1\models\Tbothers';
	public $serializer = [ 
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items' 
	];
	
	public function actionList(){
		
		$data=Yii::$app->request->post();
		
		$longitude = $data['longitude'];
		$latitude = $data['latitude'];
		$query=(new \yii\db\Query ())
		->select('tbothers.*,users.phone,users.thumb,users.nickname')
		->from('tbothers')
		->orderBy(sprintf('abs(tbothers.longitude - %f) + abs(tbothers.latitude - %f)',$longitude,$latitude))
		->join('INNER JOIN','users','users.id = tbothers.userid');
		
		if(isset($data["content"])){
			$query = $query->andFilterWhere(['like', 'content',$data['content']]);
		}
		
		$dataProvider=new ActiveDataProvider([
				'query' => $query,
		]);
		
		$daters = $dataProvider->getModels();
		//$result = array ();
		//$result ['item'] = array ();
		
		//$tbreplys = (new \yii\db\Query ())->select('tbreplys.*,users.phone,users.nickname,users.thumb')->orderBy ( "tbreplys.created_at desc" )->join ( 'INNER JOIN', 'users', ' tbmessages.userid =users.id ')->where('tbreplys.messageid in ');
		
		foreach ( $daters as $i=>$dater ) {
			$info = $dater;
				
			$info["distance"] = $this->getDistance($latitude, $longitude, $info['latitude'], $info['longitude']);
		
			$daters[$i] = $info;
		
		}
		$dataProvider->setModels($daters);
		
		return $dataProvider;
	}
	
	function getDistance($lat1, $lng1, $lat2, $lng2)
	{
		$earthRadius = 6367000; //approximate radius of earth in meters
	
		/*
		 Convert these degrees to radians
		 to work with the formula
		 */
	
		$lat1 = ($lat1 * pi() ) / 180;
		$lng1 = ($lng1 * pi() ) / 180;
	
		$lat2 = ($lat2 * pi() ) / 180;
		$lng2 = ($lng2 * pi() ) / 180;
	
		/*
		 Using the
		 Haversine formula
	
		 http://en.wikipedia.org/wiki/Haversine_formula
	
		 calculate the distance
		 */
	
		$calcLongitude = $lng2 - $lng1;
		$calcLatitude = $lat2 - $lat1;
		$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
		$calculatedDistance = $earthRadius * $stepTwo;
	
		return round($calculatedDistance);
	}
	
	public function actionMy(){
		$data=Yii::$app->request->post ();
		$user =Users::findOne(['phone'=>$data['phone']]);
		
		$query=(new \yii\db\Query ())->select('tbothers.*,users.phone,users.thumb,users.nickname')->from('tbothers')->join('INNER JOIN','users','users.id = tbothers.userid and users.id = :id',[':id'=>$user['id']])->orderBy('tbothers.created_at desc');
		$dataProvider=new ActiveDataProvider([
				'query' => $query,
		]);
		return $dataProvider;
	}
	public function actionSend() {
		$data = Yii::$app->request->post ();
		$model = new Tbothers ();
		$phone = Users::findOne ( [ 
				'phone' => $data ['phone'] 
		] );
		// $msg->userid = Yii::$app->user->id;
		$model->userid = $phone ['id'];
		$model->title = $data ['title'];
		$model->content = $data ['content'];
		$model->pictures = isset($data['pictures'])?$data['pictures']:"";
		$model->longitude = isset($data['longitude'])?$data['longitude']:0;
    $model->latitude = isset($data['latitude'])?$data['latitude']:0;
		$model->created_at = time ();
// 		for($i=1;$i<=9;$i++){
//         	$msg->setAttribute('picture'. $i, isset($data['picture' . $i])?$data['picture' . $i]:'');
//         }
		if ($model->save ()) {
			return array (
					'flag' => 1,
					'msg' => 'Send success!'
			);
		}else{
			return   array (
					'error'=>$model->errors,
					'flag' => 0,
					'msg' => 'Send fail!' 
			);
		}
	}
	public function actionDelete()
	{
		$data=Yii::$app->request->post();
		if(!isset($data['phone'])||!isset($data['tbotherid'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		$model=$this->findModel($data['tbotherid']);
		if (!$model||!$user){
			return  array (
					'flag' => 0,
					'msg' => 'delete fail!'
			);
		}
		if ($model->userid == $user->id){
			if($model->delete()){
				return 	array (
						'flag' => 1,
						'msg' => 'delete success!'
				);
			}else{
				return 	array (
						'flag' => 0,
						'msg' => 'delete fail!'
				);
			}
		}else{
			return 	array (
					'flag' => 0,
					'msg' => 'have no authority!'
			);
		}
	}
	protected function findModel($id)
	{
		if (($model = Tbothers::findOne($id)) !== null) {
			return $model;
		}else {
			return false;
		}
	}
}