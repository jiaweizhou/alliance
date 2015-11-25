<?php
namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Users;
use yii\rest\Controller;
use Qiniu\Auth;
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
		if(!$user||$user->isdraw>30){
			return 	array (
					'flag' => 0,
					'msg' => 'no user or user has drawed before',
			);
		}
		$count=$this->next();
		
		$user->cornsforgrab+= $count;
		$user->isdraw ++;
		$user->save();
		
		return array(
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
			$lucky = array(1,2,3,4,5,6,7,8,9);
			shuffle ($lucky);
		}
		$count = array_splice($lucky, 0, 1);
		file_put_contents($file, json_encode($lucky));
		$lock->unlock();
		
		return $count[0];
		
		
		//return ;
	}
}