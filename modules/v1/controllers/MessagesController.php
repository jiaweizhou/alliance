<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
//use yii\filters\AccessControl;
use app\modules\v1\models\Messages;
use app\modules\v1\models\Messagetopictures;
use app\modules\v1\models\Users;
use app\modules\v1\models\Zans;
//use app\modules\v1\models\Notify;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Replys;
//use app\modules\v1\models\Appcomments;

// require dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/../vendor/pushserver/sdk.php';
// use PushSDK;
// use app\modules\v1\models\Appl;

class MessagesController extends Controller {
	public $modelClass = 'app\modules\v1\models\Messages';
	public $serializer = [ 
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items' 
	];
	public function actions() {
		$actions = parent::actions ();
		unset ( $actions ['index'] );
		unset ( $actions ['view'] );
		return $actions;
	}

	public function actionGet() {
		$data = Yii::$app->request->post ();
		$phone = Users::findOne ( [ 
				'phone' => $data ['phone'] 
		] );
		// $data = Message::find ()->select ( 'msg.id' )->join ( 'INNER JOIN', 'friends', ' msg.userid =friends.friendid and msg.userid = :id ', [':id' => Yii::$app->user->id ]);
		$data = Messages::find ()->distinct()->select ('messages.id')->join ( 'INNER JOIN', 'friends', ' messages.userid =friends.friendid and friends.myid = :id  or messages.userid = :id', [ 
				':id' => $phone ['id'] 
		] );
		$pages = new \yii\data\Pagination ( [ 
				'totalCount' => $data->count (),
				'pageSize' => '10' 
		] );
		$models = $data->orderBy ( "messages.created_at desc" )->offset ( $pages->offset )->limit ( $pages->limit )->all ();
		//$models = $data->orderBy ( "msg.created_at desc" )->limit ( $pages->limit )->all ();
		//$models = $data->orderBy ( "msg.created_at desc" )->all ();
		$result = array ();
		$result ['item'] = array ();
		foreach ( $models as $model ) {
			$msg = (new \yii\db\Query ())->select ( [ 
					'messages.*',
					'users.phone',
					'users.nickname',
					'users.thumb' 
			] )->from ( 'messages' )->join ( 'INNER JOIN', 'users', 'messages.userid = users.id and messages.id = :id', [ 
					':id' => $model ['id'] 
			] )->one ();
			$info = $msg;
			//unset($msg['id']);
			//$info['appkinds'] = explode(" ", $info['appkinds']);msg
			
			$info ['pictures'] = (new \yii\db\Query ())->select ( [ 
					'messagetopictures.picture' 
			] )->from ('messagetopictures')
			->where(['messageid' => $msg['id']])->all();
			
			$info ['replys'] = (new \yii\db\Query ())->select ( [ 
					'replys.*',
					'user1.nickname as fromnickname',
					'user1.phone as fromphone',
					'user2.nickname as tonickname',
					'user2.phone as tophone' 
			] )->from ( 'replys' )->join ( 'INNER JOIN', 'users user1', 'user1.id = replys.fromid and replys.messageid = :id', [ 
					':id' => $model ['id'] 
			] )->join ( 'Left JOIN', 'users user2', 'user2.id = replys.toid' )->orderBy ( "replys.created_at" )->all ();
			
			$info['zan']=(new \yii\db\Query())
			->select('u.phone,u.nickname')->from('zans z')
			->join('INNER JOIN','users u','u.id=z.userid and z.msgid=:id',[':id'=>$model ['id'] ])
			->all();
			
			$result ['item'] [] = $info;
		}
		$result ['_meta'] = array (
				'pageCount' => $pages->pageCount,
				'currentPage' => $pages->page + 1 
		);
		return $result;
		// return $model;
	}
	public function actionSend() {
		$data = Yii::$app->request->post ();
		$msg = new Messages ();
		$phone = Users::findOne ( [ 
				'phone' => $data ['phone'] 
		] );
		// $msg->userid = Yii::$app->user->id;
		$msg->userid = $phone ['id'];
		$msg->content = $data ['content'];
		$msg->created_at = time ();
		
		if ($msg->save ()) {
			if (isset($data ['pictures'] )){
				foreach ( $data ['pictures'] as $picture ) {
					$mp = new Messagetopictures();
					$mp->messageid = $msg->id;
					$mp->picture = $picture;
					$mp->save();	
				}
			}
			return array (
					'flag' => 1,
					'msg' => 'Send success!'
			);
		}else{
			return   array (
					'flag' => 0,
					'msg' => 'Send fail!' 
			);
		}
	}
	public function actionDelete() {
		$data = Yii::$app->request->post ();
		$id = $data ['id'];
		$msg = new Messages ();
		$msg = Messages::find ()->where(['id' =>$id])->one();
		if ($msg == null) {
			return array (
					'flag' => 0,
					'msg' => 'Message do not exist!'
			);
		}
		if ($msg->delete ()) {
			
			return array (
					'flag' => 1,
					'msg' => 'Delete success!'
			);
		} else {
			return  array (
					'flag' => 0,
					'msg' => 'Delete failed!'
			);
		}
	}
	public function actionZan() {
		$data = Yii::$app->request->post ();
		$user = new Users ();
		$phone = $user->find ()->select ( 'id' )->where ( [ 
				'phone' => $data ['phone'] 
		] )->one ();
		$info = Zans::findOne ( [ 
				'userid' => $phone ['id'],
				'msgid' => $data ['msgid'] 
		] );
		if ($info) {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Already zan!' 
			) );
		} else {
			$model = new Zans ();
			
			$model->userid = $phone ['id'];
			$model->msgid = $data ['msgid'];
			$model->save ();
// 			$to=Message::findOne(['id'=>$data['msgid']]);
// 			$model2=new Notify();
// 			$model2->from=$phone['id'];
// 			$model2->to=$to['userid'];
// 			$model2->kind='点赞';
// 			$model2->created_at=time();
// 			$model2->msg_id=$data['msgid'];
// 			$model2->save();
			return  array (
					'flag' => 1,
					'msg' => 'Zan success!' 
			);
		}
	}
	public function actionCancelzan() {
		$data = Yii::$app->request->post ();
		$user = new Users ();
		$phone = $user->find ()->select ( 'id' )->where ( [ 
				'phone' => $data ['phone'] 
		] )->one ();
		$info = Zans::findOne ( [ 
				'userid' => $phone ['id'],
				'msgid' => $data ['msgid'] 
		] );
		if ($info) {
			if($info->delete ()){
				return array (
						'flag' => 1,
						'msg' => 'Cancel success!' 
				);
			}else{
				return array (
						'flag' => 0,
						'msg' => 'Cancel fail!'
				);
			}
		} else {
			return array (
					'flag' => 0,
					'msg' => 'Already Canceled!' 
			);
		}
	}
	public function actionReply() {
		$data = Yii::$app->request->post ();
		//$user=new Users();
		$fromphone=Users::find()->select('id')->where(['phone'=>$data['fphone']])->one();
		//var_dump($fromphone);
		$model=new Replys();
		if($data['tphone']==''){
			$model->toid=0;
		}else{
			$tophone=Users::find()->select('id')->where(['phone'=>$data['tphone']])->one();
			//var_dump($tophone);
			$model->toid=$tophone['id'];
		}
// 		$to=Messages::findOne(['id'=>$data['msgid']]);
// 		if($fromphone['id']!=$to['id']){
// 			$model3=new Notify();
// 			$model3->from=$fromphone['id'];
// 			$model3->to=$to['userid'];
// 			//$model3->kind='评论';
// 			$model3->kind=$data['content'];
// 			$model3->created_at=time();
// 			$model3->msg_id=$data['msgid'];
// 			if(!$model3->save()){
// 				echo json_encode ( array (
// 						'flag' => 0,
// 						'msg' => 'Reply failed!'
// 				));
// 				return;
// 			}
// 		}
		
		$model->fromid=$fromphone['id'];
		$model->messageid=$data['msgid'];
		$model->content=$data['content'];
		$model->isread=0;
		$model->created_at=time();
		//var_dump($model);
		if($model->save()){
			return array (
					'flag' => 1,
					'msg' => 'Reply success!'
			);
		}else{
			return array (
					'flag' => 0,
					'msg' => 'Reply failed!'
			);
		}
	}
	public function actionBeforeSend(){
		$data=Yii::$app->request->post();
		$ans=array();
		foreach ($data['packages'] as $package){
			$ans[$package]=array();
			$app=Appl::findOne(['package'=>$package]);
			if($app){
				$ans[$package]['appid']=$app->id;
				$ans[$package]['tag']=$app->kind;
				$ans[$package]['exist']=1;
			}else{
				$ans[$package]['appid']=0;
				$ans[$package]['tag']='';
				$ans[$package]['exist']=0;
			}
		}
		return $ans;
	}
	
	public function actionIosbefSend(){
		$data=Yii::$app->request->post();
		$ans=array();
		foreach ($data['packages'] as $package){
			$ans[$package]=array();
			$app=Appl::findOne(['ios_package'=>$package]);
		if($app){
				$ans[$package]['appid']=$app->id;
				$ans[$package]['tag']=$app->kind;
				$ans[$package]['exist']=1;
			}else{
				$ans[$package]['appid']=0;
				$ans[$package]['tag']='';
				$ans[$package]['exist']=0;
			}
		}
		return $ans;
	}
	
	public function actionPush() {
		$sdk = new PushSDK ();
		$channelId = '4483825412066692748';
		$message = array (
				// 消息的标题.
				'title' => 'Hi!.',
				// 消息内容
				'description' => "杨老板卧槽" 
		);
		
		// 设置消息类型为 通知类型.
		$opts = array (
				'msg_type' => 1 
		);
		
		// 向目标设备发送一条消息
		$rs = $sdk->pushMsgToAll($message, $opts);
		//pushMsgToSingleDevice ( $channelId, $message, $opts );
		
		// 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
		if ($rs === false) {
			print_r ( $sdk->getLastErrorCode () );
			print_r ( $sdk->getLastErrorMsg () );
		} else {
			// 将打印出消息的id,发送时间等相关信息.
			print_r ( $rs );
		}
		echo "done!";
	}
	public function actionTestl(){
		echo "sss";
		$dataProvider = new ActiveDataProvider ( [
		 'query' => Appcomments::find ()
				] );
		//$dataProvider->keys;
		//$dataProvider->models;
		/*$dataProvider->setPagination(false);
		$mymodel=$dataProvider->models;
		foreach ($mymodel as $model){
			echo $model['appid'];
			
		}*/
		$pagination = $dataProvider->getPagination();
		var_dump($pagination->page);
	    $count=0;
		while ($categories = $dataProvider->models){
			/*foreach ($categories as $model) {
				$model['appid']=0;
			}*/
			//echo $pagination->page=1+$count;
			$count++;
			$dataProvider->setPagination($count);
		}
		//$mymodel[4]['kind']="bbbbbb";
		//$dataProvider->setModels($mymodel);
		//var_dump($dataProvider->models[4]['kind']);
		//echo $dataProvider->models;
	}
}
