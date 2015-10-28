<?php
namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Users;
use yii\rest\Controller;
use Qiniu\Auth;

class UsersController extends Controller {
	// for user to upload icon
	public function actionToken() {
		$accessKey = '6dnAU0jREe7QO0nD1ujr6CizVZ87HGhivNS1W9hR';
		$secretKey = 'RYuzaeIJDvFb8KOa9OSlsmlVs7j9A6oFbzwjh9Z0';
		$auth = new Auth ( $accessKey, $secretKey );
		$bucket = 'alliance';
		$token = $auth->uploadToken ( $bucket );
		echo json_encode(array(
				'token'=>$token
		));
	}
	
	//for sign up
	public function actionSignup() {
		$model = new Users ();
		$data = Yii::$app->request->post ();
		$model->pwd = md5 ( $data ['pwd'] );
		$model->phone = $data ['phone'];
		$userinfo = User::findOne ( [
				'phone' => $data ['phone']
		] );
		if ($userinfo&&$userinfo->blacklist==0) {
			$userinfo->pwd = md5 ( $data ['pwd'] );
			$userinfo->save ();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'change pwd success!'
			) );
		} else if ($userinfo&&$userinfo->blacklist==1){
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Signup failed!'
			) );
		} else{
			$model->created_at = time ();
			$model->save ();
			echo json_encode ( array (
					'flag' => 1,
					'msg' => 'Signup success!'
			) );
			// return 1;
			// return json_encode("sighup success");
		}
	}
	public function actionSetchannel(){
		$data = Yii::$app->request->post ();
		$user=Users::find()->where(['phone'=>$data['phone']])->one();
		if ($user){
			$user.updateChannel($data['channel']);
		}
	}
}