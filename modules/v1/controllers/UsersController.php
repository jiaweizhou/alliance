<?php
namespace app\modules\v1\controllers;

use Yii;
use Exception;
use app\modules\v1\models\Users;
use yii\rest\Controller;
use Qiniu\Auth;
use app\modules\v1\models\Easeapi;
use app\modules\v1\models\Text;
use yii\rest\Serializer;
use app\modules\v1\models\Addresses;
use app\modules\v1\models\Realauth;
use app\modules\v1\models\Usertocards;
use app\modules\v1\models\Traderecords;
use yii\data\ActiveDataProvider;

use function Qiniu\json_decode;
use app\modules\v1\models\app\modules\v1\models;
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
	
	public function actionTraderecords(){
		$data = Yii::$app->request->post();
		if(empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		
		$user = Users::findOne(['phone'=>$data['phone']]);
		
		$query = (new \yii\db\Query ())
			->from('traderecords')
			->where('userid = ' . $user->id)
			->orderBy('created_at desc');
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
		]);
		
		return $dataProvider;
	}
	
	public function actionMoneyin(){
		$data = Yii::$app->request->post();
		if(empty($data['count'])||empty($data['type'])||empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		$model =  new Traderecords();
		$model->userid = $user['id'];
		$model->type = $data['type'];
		if($model->type == 1){
			$model->description = '自己人联盟支付宝充值';
		}else if($model->type == 2){
			$model->description = '自己人联盟微信支付充值';
		}
		$model->cardid = 0;
		$model->count = $data['count'];
		$model->created_at = time();
		try{
			$result=$model->getDb()->transaction(function($db) use ($model,$user) {
				if(!$model->save()){
					throw new Exception("save traderecord fail");
				}
				$rows = Users::updateAllCounters(['money'=>$model['count']],['id'=>$user['id']]);
				if($rows != 1){
					throw new Exception("update user fail");
				}
			});
		} catch (\Exception $e) {
			return array (
					'flag' => 0,
					'error'=>$e->getMessage(),
					'msg' => 'money in fail!'
			);
		}
		
		return array(
				'flag' => 1,
				'msg' => 'money in success!'
		);
	}
	
	public function actionMoneyout(){
		$data = Yii::$app->request->post();
		if(empty($data['count'])||empty($data['cardid'])||empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		$model =  new Traderecords();
		$model->userid = $user['id'];
		$model->type = -1;
		$model->description = '自己人联盟用户提现';
		$model->cardid = $data['cardid'];
		$model->count = $data['count'];
		$model->ishandled = 1;
		$model->created_at = time();
		try{
			$result=$model->getDb()->transaction(function($db) use ($model,$user) {
				if(!$model->save()){
					throw new Exception("save traderecord fail");
				}
				$rows = Users::updateAllCounters(['money'=>$model['count']],['id'=>$user['id']]);
				if($rows != 1){
					throw new Exception("update user fail");
				}
			});
		} catch (\Exception $e) {
			return array (
					'flag' => 0,
					'error'=>$e->getMessage(),
					'msg' => 'money out fail!'
			);
		}
	
		return array(
				'flag' => 1,
				'msg' => 'money out success!'
		);
	}
	
	public function actionSearch(){
		$data = Yii::$app->request->post();
		if(empty($data['search'])||empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$me = Users::findOne(['phone'=>$data['phone']]);
		
		$users = (new \yii\db\Query ())
		->distinct('users.id')
		->select(['users.id','users.id as huanxinid','phone','nickname','concerncount','thumb','if(isnull(friends.id),0,1) as isfriend'])
		->from('users')
		->join('LEFT JOIN','friends','friends.myid = users.id')
		->where(['phone'=>$data['search']])
		->orFilterWhere(['like','nickname',$data['search']])
		->all();
		$t = array();
		foreach ($users as $user){
			$t[]=$user['id'];
		}
		
		if(empty($t)){
			return array();
		}
		
		$friendcounts = (new \yii\db\Query ())
		->select('myid , count(id) as friendcount')
		->from('friends')
		->where('myid in ('.join($t, ',').')')
		->groupBy('myid')
		->all();
		$l=array();
		foreach ($friendcounts as $friendcount){
			$l[$friendcount['myid']] = $friendcount['friendcount'];
		}
		foreach ($users as $i=>$j){
			$t=$users[$i]['id'];
			if(isset($l[$t])){
				$users[$i]['friendcount'] = $l[$t];
			}
			//$f[$i]['friendcount'] = $l[];
		}
		return $users;
	}
	
	public function actionRealinfo(){
		$data = Yii::$app->request->post();
		if(empty($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		return Realauth::findone(['userid'=>$user['id']]);
		
	}
	
	
	public function actionRealauth(){
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
					'msg' => 'no user with phone this!'
			);
		}
		$model = new Realauth();
		$model['userid'] = $user['id'];
		$model['realname'] = $data['realname'];
		$model['idcard'] = $data['idcard'];
		$model['picture'] = isset($data['picture'])?$data['picture']:'';
		$model['created_at'] = time();
		try{
			$result=$model->getDb()->transaction(function($db) use ($model,$user) {
				if(!$model->save()){
					throw new Exception("status is not 0");
				}
				if($user['status']!=0)
					throw new Exception("status is not 0");
				else {
					$user['status']=1;
					$user->save();
				}
			});
		} catch (\Exception $e) {
			return array (
					'flag' => 0,
					'error'=>$model->errors,
					'msg' => 'checkauth false!'
			);
		}
		return array (
				'flag' => 1,
				'msg' => 'checkauth ok!'
		);

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
		$result=Addresses::updateAll(['isdefault'=>1],['id'=>$data['addressid']]);
		if($result){
			return array(
					'flag'=>1,
					'msg'=>'ok'
			);
		}else{
			return array(
					'flag'=>0,
					'msg'=>'false'
			);
		}
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
	
	public function actionModifyaddress(){
		$data = Yii::$app->request->post();
		if(!(isset($data['phone'])&&isset($data['addressid']))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		$address = Addresses::findOne(['id'=>$data['addressid']]);
		unset($data['phone']);
		unset($data['addressid']);
		if($address['userid']!= $user['id']){
			return 	array (
					'flag' => 0,
					'msg' => 'not your address!'
			);
		}
		foreach ($data as $item=>$arg ){
			$address->$item = $arg;
		}
		
        if ($address->save()) {
            return 	array (
        			'flag' => 1,
        			'msg' => 'update address success!'
        	);
        } else {
            return  array (
    				'flag' => 0,
    				'msg' => 'update address fail!'
    		);
        }
		
		
	}
	
	public function actionSetpaypwd(){
		$data=Yii::$app->request->post();
		if(empty($data['phone'])||empty($data['newpaypwd'])){
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
		if(!empty($user['paypwd'])){
			if(empty($data['oldpaypwd'])){
				return array (
					'flag' => 0,
					'msg' => 'not oldpaypwd!'
				);
			}
			if($user['paypwd']!=md5($data['oldpaypwd'])){
				return array (
						'flag' => 0,
						'msg' => 'oldpaypwd not right!'
				);
			}
		}
		$user['paypwd'] = md5($data['newpaypwd']);
		if($user->save()){
			return array (
					'flag' => 1,
					'msg' => 'set paypwd access!'
				);
		}else{
			return array (
					'flag' => 0,
					'msg' => 'set paypwd failure!'
			);
		}
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
		//$cardcount = ()
		
		$cardcount = (new \yii\db\Query ())->select('count(id) as cardcount')->from('usertocards')->where(['userid'=>$user['id']])->one();
		return array(
				'cardcount'=> $cardcount['cardcount'],
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
			//Text::deleteAll(['phone'=>$data['phone'],'type'=>$type]);
			return array(
					'flag'=>0,
					'msg'=>'text not right',
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
	public function actionCode(){
		//$data = Yii::$app->request->post ();
		//return $this->to62(5800235584+$data['id']);
		$users = Users::find()->all();
		foreach ($users as $user){
			$user['invitecode'] = $this->to62(5800235584+$user['id']);
			$user->save();
		}
	}
	
	public function actionSetcode(){
		$data = Yii::$app->request->post ();
		if(empty($data['phone'])||empty($data['code'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$userinfo = Users::findOne ( [
				'phone' => $data ['phone']
		] );
		if(!$userinfo||!empty($userinfo['fatherid'])){
			return array (
					'flag' => 0,
					'msg' => 'already set'
			);
		}
		
		$father = Users::findOne(['invitecode'=>$data['code']]);
		if(!$father){
			return array (
					'flag' => 0,
					'msg' => 'code not exist'
			);
		}
	
		if($userinfo->setFather($father['id'])){
				$userinfo->save();
				return array (
					'flag' => 1,
					'msg' => 'set father access'
			);
		}else{
			return array (
					'flag' => 0,
					'msg' => 'set failure'
			);
		}
	}
	
	public function actionSignup() {
		$model = new Users ();
		//$t=Yii::$app->request->params;
		$t=Yii::$app->request->getQueryParams();
		$data = Yii::$app->request->post ();
		//return $t;
		if(empty($data['phone'])||empty($data['pwd'])||empty($data['text'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		
		$userinfo = Users::findOne ( [
				'phone' => $data ['phone']
		] );
		if ($userinfo){
			
			return array (
					'flag' => 0,
					'msg' => 'already Signup!'
			) ;
				
		}
		
		$r=$this->checktext($data,0);
		if($r['flag']==0)
			return $r;
		$model->pwd = md5 ( $data ['pwd'] );
		$model->phone = $data ['phone'];
		$model->alliancerewards = 30;
		
		$model->created_at = time ();
		if($model->save ()){
			
			$model['invitecode'] = $this->to62(5800235584+$model['id']);
			$model->save();

			$easeclient=new Easeapi('YXA6halokJDEEeWMRgvYONLZPQ','YXA6pswnZbss8mj351XE3oxuRYm6cek','13022660999','allpeopleleague','file');
			$result=$easeclient->curl('/users',array('username'=>$model->id,'password'=>$data ['pwd']));
			//var_dump($result);
			$result = json_decode($result['result'],true);
			if(isset($result['error'])){
				$model->delete();
				return  array (
					//'error'=> $result,
					'flag' => 0,
					'msg' => 'Signup fail!'
				) ;
			}else{
				
				if($t){
					if(!$this->setfather($model, $t))
						return array (
								'flag' => 0,
								'msg' => 'Modify fail!'
						);
				}
				
				return  array (
						'flag' => 1,
						'huanxinid'=>$model['id'],
						'msg' => 'Signup success!'
				) ;
			}
		}else{
			return  array (
				//'error'=>$model->errors,
				'flag' => 0,
				'msg' => 'Signup fail!'
			) ;
		}

	}
	public function actionGetsignupurl(){
		$data = Yii::$app->request->post ();
		$model=Users::findone(['phone'=>$data['phone']]);
// 		$encode = Users::encrypt(json_encode(array('id'=>$model['id'],'time'=>time())),'E','asdfsgf');
// 		$decode = Users::encrypt($encode,'D','asdfsgf');
// 		return array(
// 				'e'=>$encode,
// 				'd'=>$decode,
// 		);
		return Yii::$app->request->getHostInfo().'/v1/users/signup?fatherid='.Users::encrypt(json_encode(array('id'=>$model['id'],'time'=>time())),'E','asdfsgf');
	}
	public function actionView(){
		$data = Yii::$app->request->post ();
		$model=(new \yii\db\Query ())->from('users')->where(['phone'=>$data['phone']])->one();
		unset($model['paypwd']);
		unset($model['pwd']);
		$model['huanxinid'] = $model['id'];
		
		$friendcounts = (new \yii\db\Query ())
		->select('count(id) as friendcount')
		->from('friends')
		->where('myid ='. $model['id'])
		->One();
		
		//var_dump($friendcounts);
		$model['friendcount'] = $friendcounts['friendcount'];
		
		return $model;
	}
	public function actionChangepwdbypwd(){
		$data = Yii::$app->request->post ();
		$model=Users::findone(['phone'=>$data['phone']]);
		if($model['pwd']!=md5($data['pwd'])){
			return  array (
					'flag' => 0,
					'msg' => 'pwd error!'
			) ;
		}
		$model['pwd'] = md5($data['newpwd']);	
		try{
			$result=$model->getDb()->transaction(function($db) use ($model,$data) {
				$model->save();
				$easeclient=new Easeapi('YXA6halokJDEEeWMRgvYONLZPQ','YXA6pswnZbss8mj351XE3oxuRYm6cek','13022660999','allpeopleleague','file');
				$result=$easeclient->curl('/users/'.$model['id'].'/password',array('newpassword'=>$data ['newpwd']),'PUT');
				$status=$result['status'];
				$result = json_decode($result['result'],true);
				//echo $result;
				if($status!=200){
					throw new Exception(json_encode($result));
				}
			});
		} catch (\Exception $e) {
			return array (
					'flag' => 0,
					'error'=>$e,
					'hh'=>$model->errors,
					'msg' => 'modifa password false!'
			);
		}
		return array (
				'flag' => 1,
				'msg' => 'Modify success!'
		);
	
	}
	public function actionChangepwd(){
		$data = Yii::$app->request->post ();
		$model=Users::findone(['phone'=>$data['phone']]);
		
		$model['pwd'] = md5($data['pwd']);
		if ($model->save()) {
			$easeclient=new Easeapi('YXA6halokJDEEeWMRgvYONLZPQ','YXA6pswnZbss8mj351XE3oxuRYm6cek','13022660999','allpeopleleague','file');
			$result=$easeclient->curl('/users/'.$model['id'].'/password',array('newpassword'=>$data ['pwd']),'PUT');
			$status=$result['status'];
			$result = json_decode($result['result'],true);
			if($status!=200){
				//$model->delete();
				return  array (
						'error'=> $result,
						'flag' => 0,
						'msg' => 'Signup fail!'
				) ;
			}
			return array (
					'flag' => 1,
					'msg' => 'Modify success!'
			);
		} else {
			return  array (
					'flag' => 0,
					'msg' => 'Modify fail!'
			);
		}
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
		unset($data['paypwd']);
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
			);
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
		//$model=new Users();
		$info=Users::findOne(['phone'=>$data['phone'],'pwd'=>md5($data['pwd'])]);
		if($info){
			$r=$info->toArray();
			unset($r['pwd']);
			unset($r['paypwd']);
			//unset($r['pwd'])
			$r['huanxinid'] = $r['id'];
			$r['flag'] =1;
			
			echo json_encode ($r);
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
	
	public function setfather(&$user,$data){
		//$data = Yii::$app->request->post ();
			$info = json_decode(Users::encrypt($data['fatherid'],'D','asdfsgf'),true);
			//var_dump($info);
			if($user->setFather($info['id'])){
				$user->save();
				return 1;
			}else{
				return 0;
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
	public function to62($num) {
	  	$to = 62;
	  	$dict = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	  	$ret = '';
	  	do {
	    	$ret = $dict[bcmod($num, $to)] . $ret;
	    	$num = bcdiv($num, $to);
	  	} while ($num > 0);
	 	return ltrim($ret,"0");
	}
}
