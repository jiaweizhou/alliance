<?php
namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Users;
use yii\rest\Controller;
use Qiniu\Auth;
use app\modules\v1\models\Easeapi;
use yii\rest\Serializer;
class UsersController extends Controller {
	public $modelClass = 'app\modules\v1\models\Users';
	public $serializer = [
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items'
	];
	public function actionTest(){
		//$model = Users::find()->where('id = 1')->one();
		$data = Yii::$app->request->post();
		$user=Users::find()->where(['phone'=>$data['phone']])->one();
		return $user;
	}
	//for sign up
	
	public function actionSignup() {
		$model = new Users ();
		$data = Yii::$app->request->post ();
		if(empty($data['phone'])||empty($data['pwd'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$model->pwd = md5 ( $data ['pwd'] );
		$model->phone = $data ['phone'];
		$userinfo = Users::findOne ( [
				'phone' => $data ['phone']
		] );
		if ($userinfo){
			return array (
			'flag' => 0,
			'msg' => 'already Signup!'
			) ;
		}
		$model->created_at = time ();
		if($model->save ()){
			$easeclient=new Easeapi('YXA6halokJDEEeWMRgvYONLZPQ','YXA6pswnZbss8mj351XE3oxuRYm6cek','13022660999','allpeopleleague','file');
			$result=json_decode($easeclient->curl('/users',array('username'=>$model->id,'password'=>$data ['pwd'])),true);
			if(isset($result['error'])){
				$model->delete();
				return  array (
					'error'=> $result,
					'flag' => 0,
					'msg' => 'Signup fail!'
				) ;
			}else{
				return  array (
						'flag' => 1,
						'msg' => 'Signup success!'
				) ;
			}
		}else{
			return  array (
				'error'=>$model->errors,
				'flag' => 0,
				'msg' => 'Signup fail!'
			) ;
		}

	}
	
	public function actionModify() {
		
		$data = Yii::$app->request->post ();
		$data=Yii::$app->request->post();
		if(empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$model=Users::findone(['phone'=>$data['phone']]);
		
		foreach ($data as $key=>$value){
			$model->$key = $value;
		}
		
		if ($model->save()) {
			return array (
					'flag' => 1,
					'msg' => 'Modify success!'
			);
		} else {
			return  array (
					'flag' => 0,
					'msg' => 'Modify fail!'
			) ;
		}
	}
	public function actionLogin() {
		$data=Yii::$app->request->post();
		if(empty($data['phone'])||empty($data['pwd'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$model=new Users();
		$info=$model->findOne(['phone'=>$data['phone'],'pwd'=>md5($data['pwd'])]);
		if($info){
			echo json_encode ( array (
					'flag' => 1,
					'username'=>$info->id,
					'msg' => 'Login success!'
			) );
		}else{
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Login failed!'
			) );
		}
	}
	
	public function actionLogout() {
		//Yii::$app->user->logout ();
		$data=Yii::$app->request->post();
		$model=new Users();
		$info=$model->findOne(['phone'=>$data['phone']]);
		if($info){
			return array (
					'flag' => 1,
					'username'=>$info->id,
					'msg' => 'Logout success!'
			);
		}else{
			return  array (
					'flag' => 0,
					'msg' => 'Logout failed!'
			);
		}
	}
	
	public function actionSetfather(){
		$data = Yii::$app->request->post ();
		$user=Users::findOne(['phone'=>$data['phone']]);
		if ($user){
			if($user->fatherid!=''){
				return array('flag'=>0,'msg'=> 'father has been setted');
			}
			if($user->setFather($data['fatherphone'])){
				return array('flag'=>1,'msg'=> 'update father success');
			}else{
				return array('flag'=>0,'msg'=> 'update father fail');
			}
		}else{
			return array('flag'=>0,'msg'=> 'can not find the user');
		}
	
	}
	public function actionSetchannel(){
		$data = Yii::$app->request->post ();
		$user=Users::find()->where(['phone'=>$data['phone']])->one();
		if ($user){
			if($user.updateChannel($data['channel'])){
				return array('flag'=>1,'msg'=> 'update user channel success');
			}else{
				return array('flag'=>0,'msg'=> 'update user channel fail');
			}
		}else{
			return array('flag'=>0,'msg'=> 'can not find the user');
		}
		
	}
	public function actionToken() {
		$accessKey = 'xcKDqVaZ6kg0GJL7F0XoJejA-bKuHeDFByLWtp5t';
		$secretKey = 'ccns4VlA6Zy21PPQn_1N7wgSlU0WYSf9n7TQ4l2f';
		$auth = new Auth ( $accessKey, $secretKey );
		$bucket = 'allpeopleleague';
		$token = $auth->uploadToken ( $bucket );
		echo json_encode(array(
				'token'=>$token
		));
	}
}