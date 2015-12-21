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
		$query=(new \yii\db\Query ())->select('tbothers.*,users.phone,users.thumb,users.nickname')->from('tbothers')->join('INNER JOIN','users','users.id = tbothers.userid')->orderBy('tbothers.created_at desc');
		$dataProvider=new ActiveDataProvider([
				'query' => $query,
		]);
		return $dataProvider;
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