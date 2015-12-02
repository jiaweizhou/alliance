<?php
namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Users;
use yii\rest\Controller;
use Qiniu\Auth;
use app\modules\v1\models\Easeapi;
use app\modules\v1\models\Text;
use yii\rest\Serializer;
use app\modules\v1\models\Addresses;
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
	public function actionListaddresses(){
		$data = Yii::$app->request->post();
		if(empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$addresses = Addresses::find()->join('INNER JOIN', 'users','addresses.userid = users.id and users.phone = :phone',[':phone'=>$data['phone']])->orderBy('isdefault desc,created_at desc')->all();
		return $addresses;
	}
	
	public function actionSetdefaultaddress(){
		$data = Yii::$app->request->post();
		if(!(isset($data['phone'])&&isset($data['addressid']))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		
		Addresses::UpdateAll(['isdefault' => 0],['userid'=>$user->id]);
		
	}
	
	public function actionDeleteaddress(){
		$data = Yii::$app->request->post();
		if(!(isset($data['phone'])&&isset($data['addressid']))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
	
		if(Addresses::deleteAll(['userid'=>$user->id,'id'=>$data['addressid']])){
			return array(
					'flag'=>1,
					'msg'=>'ok',
			);
		}else{
			return array(
					'flag'=>0,
					//'err'=>$address->errors,
					'msg'=>'not ok',
			);
		}
	
	}
	
	public function actionCreateaddress(){
		$data = Yii::$app->request->post();
		if(!(isset($data['phone'])&&isset($data['address'])&&isset($data['name'])&&isset($data['aphone'])&&isset($data['postcode'])&&isset($data['isdefault']))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		
		$address = new Addresses();
		$address['userid'] = $user->id;
		$address['address'] = $data['address'];
		$address['name'] = $data['name'];
		$address['aphone']=$data['aphone'];
		$address['postcode']= $data['postcode'];
		$address['isdefault'] = $data['isdefault'];
		$address['created_at'] = time();
		if($address->save()){
			if($data['isdefault'])
				Addresses::UpdateAll(['isdefault' => 0],'userid = :userid and id != :id',[':userid'=>$user->id,':id'=>$address->id]);
			return array(
					'flag'=>1,
					'msg'=>'ok',
			);
		}else{
			return array(
					'flag'=>0,
					'err'=>$address->errors,
					'msg'=>'not ok',
			);
		}
		//addresses:= Addresses::find()->join('INNER JOIN', 'users','addresses.userid = users.id and users.phone = :phone',[':phone'=>$data['phone']]);

	}
	
	
	
	public function actionAllmoney(){
		$data = Yii::$app->request->post();
		if(empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		return array(
				'money'=>$user->money,
				'corns'=>$user->corns,
				'cornsforgrab'=>$user->cornsforgrab,
				
		);
	}
	//for sign up
	public function actionCheckrgtext(){
		$data = Yii::$app->request->post();
		return $this->checktext($data, 0);
	}
	public function actionCheckcptext(){
		$data = Yii::$app->request->post();
		return $this->checktext($data, 1);
	}
	private function checktext($data,$type){
		if(!(isset($data['phone'])&&isset($data['text']))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$text=Text::findOne(['phone'=>$data['phone'],'type'=>$type,'text'=>$data['text']]);
		
		if($text&&(time()-$text['created_at'])<10*60){
			Text::deleteAll(['phone'=>$data['phone'],'type'=>$type]);
			return array(
					'flag'=>1,
					'msg'=>'ok',
			);
		}else{
			Text::deleteAll(['phone'=>$data['phone'],'type'=>$type]);
			return array(
					'flag'=>0,
					'msg'=>'text not',
			);
		}
	}
	public function actionSendrgtext(){
		$data = Yii::$app->request->post();
		if(empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		Text::deleteAll(['phone'=>$data['phone'],'type'=>0]);
		$random = rand('1000','9999');
		$model=new Text();
		$model->phone = $data['phone'];
		$model->type = 0;
		$model->text = $random;
		$model->created_at = time();
		$model->save();
		//return $model->errors;
		//$user = User::findOne(['phone'=>$data['phone']]);
		$urlf="http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=cf_shhy&password=rjBE4e&mobile=".$data['phone']."&content=".rawurlencode("您的验证码是：".$random."。请不要把验证码泄露给其他人。如非本人操作，可不用理会！");
		$opts = array('http' =>
				array(
						'method'  => 'POST',
						'header'  => 'Content-type: application/x-www-form-urlencoded',
						//'content' => $postdata
				)
		
		);
		$context = stream_context_create($opts);
		$result = file_get_contents($urlf, false, $context);
		return array (
					'flag' => 1,
					'msg' => 'ok!'
			);
	}
	
	
	public function actionSendcptext(){
		$data = Yii::$app->request->post();
		if(empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		Text::deleteAll(['phone'=>$data['phone'],'type'=>1]);
		$random = rand('1000','9999');
		$model=new Text();
		$model->phone = $data['phone'];
		$model->type = 1;
		$model->text = $random;
		$model->created_at = time();
		$model->save();
		//return $model->errors;
		//$user = User::findOne(['phone'=>$data['phone']]);
		$urlf="http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=cf_shhy&password=rjBE4e&mobile=".$data['phone']."&content=".rawurlencode("您的验证码是：".$random."。请不要把验证码泄露给其他人。如非本人操作，可不用理会！");
		$opts = array('http' =>
				array(
						'method'  => 'POST',
						'header'  => 'Content-type: application/x-www-form-urlencoded',
						//'content' => $postdata
				)
	
		);
		$context = stream_context_create($opts);
		$result = file_get_contents($urlf, false, $context);
		return array (
					'flag' => 1,
					'msg' => 'ok!'
			);
	}
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
	public function actionView(){
		$data = Yii::$app->request->post ();
		$model=Users::findone(['phone'=>$data['phone']]);
		return $model;
	}
	public function actionModify() {
		
		$data = Yii::$app->request->post ();
		//$data=Yii::$app->request->post();
		unset($data['corns']);
		unset($data['cornsforgrab']);
		unset($data['money']);
		unset($data['fatherid']);
		unset($data['directalliancecount']);
		unset($data['allalliancecount']);
		unset($data['isdraw']);
		unset($data['pwd']);
		
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