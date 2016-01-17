<?php
namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Users;
use yii\rest\Controller;
use Qiniu\Auth;
use app\modules\v1\models\Envelopes;
use app\modules\v1\models\Easeapi;
use app\modules\v1\controllers\CacheLock;
use yii\rest\Serializer;
class EnvelopesController extends Controller {
	//public $modelClass = 'app\modules\v1\models\Users';
	public $serializer = [
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items'
	];
	//public $lucky = array();
	public function actionList(){
		return (new \yii\db\Query ())->select('envelopes.*,users.phone,users.nickname,users.nickname,users.thumb')
			->from('envelopes')
			->join('INNER JOIN','users','envelopes.userid = users.id')
			->limit(10)
			->orderBy('envelopes.count desc')
			->all();
	}
	public function actionDraw(){
		$data = Yii::$app->request->post ();
		//$data=Yii::$app->request->post();
		if(empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findone(['phone'=>$data['phone']]);
		if(!$user){
			return 	array (
					'flag' => 0,
					'msg' => 'err',
			);
		}if ($user->isdraw>30){
			return 	array (
					'flag' => 2,
					'msg' => 'no user or user has drawed before',
			);
		}
		$count=$this->next();
		
		
		$type = rand(1,2);
		switch($type){
			case 1:
				$user->money += $count;
			case 2:
				$user->cornsforgrab+= $count;
		}
		$user->isdraw ++;
		$enve=new Envelopes();
		$enve['userid'] = $user['id'];
		$enve['type'] = $type;
		$enve['count'] = $count;
		$enve['created_at'] = time();
		try{
			$result=$user->getDb()->transaction(function($db) use ($enve,$user) {
				$user->save();
				$enve->save();
			});
		} catch (\Exception $e) {
			return array (
					//'error'=>$model->errors,
					'flag' => 0,
					'msg' => 'failure!'
			);
		}
		
		$user->save();
		
		return array(
			'type'=>$type,
			'flag'=>1,
			'count'=>$count,
		);
	}
	
	private function next(){
		$lock=new CacheLock('lucky');
		$lock->lock();
		$file = 'envelopes';
		if(!is_file($file)){
			$myfile = fopen($file, "w");
			//fwrite($myfile, "{}");
			fclose($myfile);
		}
		$raw=file_get_contents($file);
		$lucky=json_decode($raw,true);
		if(!count($lucky)){
			$lucky = array(0,0,0,1,1,1);
			shuffle ($lucky);
		}
		$count = array_splice($lucky, 0, 1);
		file_put_contents($file, json_encode($lucky));
		$lock->unlock();
		
		return $count[0];
		
		
		//return ;
	}
}
