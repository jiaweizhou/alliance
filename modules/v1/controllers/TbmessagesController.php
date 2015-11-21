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

class TbmessagesController extends Controller {
	public $modelClass = 'app\modules\v1\models\Tbmessages';
	public $serializer = [ 
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items' 
	];
	public function actionNew(){
		return $this->search(Yii::$app->request->post (),1);
	}
	public function actionHot(){
		return $this->search(Yii::$app->request->post (),2);
	}
	public function actionMyconcerns(){
		return $this->search(Yii::$app->request->post (),3);
	}
	public function actionMe(){
		return $this->search(Yii::$app->request->post (),4);
	}
	public function actionMylikes(){
		return $this->search(Yii::$app->request->post (),5);
	}
	public function search($data,$type) {
		
		if(!(isset($data)&&isset($data['phone'])&&isset($type))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user =Users::findOne(['phone'=>$data['phone']]);
		$query=(new \yii\db\Query ())->select(['tbmessages.*','users.phone','users.nickname','users.thumb','if(isnull(concerns.id),0,1) as isconcerned','if(isnull(tblikes.id),0,1) as isliked'])->from('tbmessages')->join ( 'INNER JOIN', 'users', 'tbmessages.userid =users.id');
		switch ($type){
			case 1:
				$query = $query->orderBy ( "tbmessages.created_at desc" )->join('LEFT JOIN','concerns','tbmessages.userid = concerns.concernid and concerns.myid=:id',[':id'=>$user['id']])->join('LEFT JOIN','tblikes','tblikes.tbmessageid =tbmessages.id and tblikes.userid=:id',[':id'=>$user->id]);
				break;
			case 2:
				$query = $query->orderBy ( "tbmessages.likecount desc" )->join('LEFT JOIN','concerns','tbmessages.userid = concerns.concernid and concerns.myid=:id',[':id'=>$user['id']])->join('LEFT JOIN','tblikes','tblikes.tbmessageid =tbmessages.id and tblikes.userid=:id',[':id'=>$user->id]);
				break;
			case 3:
				$query = $query->orderBy ( "tbmessages.created_at desc" )->join('INNER JOIN','concerns','tbmessages.userid = concerns.concernid and concerns.myid=:id',[':id'=>$user['id']])->join('LEFT JOIN','tblikes','tblikes.tbmessageid =tbmessages.id and tblikes.userid=:id',[':id'=>$user->id]);
				break;
			case 4:
				$query = $query->orderBy ( "tbmessages.created_at desc" )->where(['tbmessages.userid'=>$user->id])->join('LEFT JOIN','concerns','tbmessages.userid = concerns.concernid and concerns.myid=:id',[':id'=>$user['id']])->join('LEFT JOIN','tblikes','tblikes.tbmessageid =tbmessages.id and tblikes.userid=:id',[':id'=>$user->id]);
				break;
			case 5:
				$query = $query->orderBy ( "tbmessages.created_at desc" )->where(['tbmessages.userid'=>$user->id])->join('LEFT JOIN','concerns','tbmessages.userid = concerns.concernid and concerns.myid=:id',[':id'=>$user['id']])->join('INNER JOIN','tblikes','tblikes.tbmessageid =tbmessages.id and tblikes.userid=:id',[':id'=>$user->id]);
				break;			
		}
// 		$dataProvider = new \yii\data\Pagination ( [ 
// 				'totalCount' => $query->count (),
// 				'pageSize' => '20' 
// 		] );
		$dataProvider=new ActiveDataProvider([
				'query' => $query,
				]);
		$tbmessages = $dataProvider->getModels();
		//$tbmessages = $query->orderBy ( "tbmessages.created_at desc" )->offset ( $dataProvider->offset )->limit ( $dataProvider->limit )->all ();
		//$models = $data->orderBy ( "msg.created_at desc" )->limit ( $pages->limit )->all ();
		//$models = $data->orderBy ( "msg.created_at desc" )->all ();
		$result = array ();
		$result ['item'] = array ();
		
		//$tbreplys = (new \yii\db\Query ())->select('tbreplys.*,users.phone,users.nickname,users.thumb')->orderBy ( "tbreplys.created_at desc" )->join ( 'INNER JOIN', 'users', ' tbmessages.userid =users.id ')->where('tbreplys.tbmessageid in ');
		
		foreach ( $tbmessages as $i=>$tbmessage ) {
			$info = $tbmessage;
			$info ['replys'] = (new \yii\db\Query ())->select ( [ 
					'tbreplys.*',
					'user1.nickname as fromnickname',
					'user1.phone as fromphone',
					'user1.thumb as fromthumb',
					'user2.nickname as tonickname',
					'user2.phone as tophone' ,
					'user2.thumb as tothumb',
			] )->from ( 'tbreplys' )->join ( 'INNER JOIN', 'users user1', 'user1.id = tbreplys.fromid and tbreplys.tbmessageid = :id', [ 
					':id' => $tbmessage['id'] 
			] )->join ( 'Left JOIN', 'users user2', 'user2.id = tbreplys.toid' )->orderBy ( "tbreplys.created_at" )->limit(20)->all ();
			
			$info['likes']=(new \yii\db\Query())
			->select('u.phone,u.nickname,u.thumb')->from('tblikes')
			->join('INNER JOIN','users u','u.id=tblikes.userid and tblikes.tbmessageid=:id',[':id'=>$tbmessage ['id'] ])
			->orderby('tblikes.created_at desc')
			->limit(10)
			->all();
			//$$dataProvider
			$tbmessages[$i] = $info;
			$result ['item'] [] = $info;
		}
		$dataProvider->setModels($tbmessages);
// 		$result['_meta'] = array(
// 			'totalCount'=>$dataProvider->totalCount,
// 			'pageCount'=>$dataProvider->pageCount,
// 			'currentPage'=>$dataProvider->page+1,
// 			'perPage'=>$dataProvider->pageSize,
// 		);
		return $dataProvider;
		// return $model;
	}
	
	public function actionMorereplys(){
		$data = Yii::$app->request->post ();
		if(!isset($data['tbmessageid']))
		{
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			); 
		}
		$query=(new \yii\db\Query ())->select ( [
				'tbreplys.*',
				'user1.nickname as fromnickname',
				'user1.phone as fromphone',
				'user1.thumb as fromthumb',
				'user2.nickname as tonickname',
				'user2.phone as tophone',
				'user2.thumb as tothumb',
				] )->from ( 'tbreplys' )->join ( 'INNER JOIN', 'users user1', 'user1.id = tbreplys.fromid and tbreplys.tbmessageid = :id', [
						':id' => $data['tbmessageid']
						] )->join ( 'Left JOIN', 'users user2', 'user2.id = tbreplys.toid' )->orderBy ( "tbreplys.created_at" );
		
		$dataProvider=new ActiveDataProvider([
				'query' => $query,
				]);
		return $dataProvider;
	}
	
	public function actionSend() {
		$data = Yii::$app->request->post ();
		$msg = new Tbmessages ();
		$phone = Users::findOne ( [ 
				'phone' => $data ['phone'] 
		] );
		// $msg->userid = Yii::$app->user->id;
		$msg->userid = $phone ['id'];
		$msg->title = $data ['title'];
		$msg->content = $data ['content'];
		$msg->pictures = isset($data['pictures'])?$data['pictures']:"";
		$msg->created_at = time ();
// 		for($i=1;$i<=9;$i++){
//         	$msg->setAttribute('picture'. $i, isset($data['picture' . $i])?$data['picture' . $i]:'');
//         }
		if ($msg->save ()) {
			return array (
					'flag' => 1,
					'msg' => 'Send success!'
			);
		}else{
			return   array (
					'error'=>$msg->errors,
					'flag' => 0,
					'msg' => 'Send fail!' 
			);
		}
	}
	public function actionDelete()
	{
		$data=Yii::$app->request->post();
		if(!isset($data['phone'])||!isset($data['tbmessageid'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$user = Users::findOne(['phone'=>$data['phone']]);
		$msg=$this->findModel($data['tbmessageid']);
		if (!$msg||!$user){
			return  array (
					'flag' => 0,
					'msg' => 'delete fail!'
			);
		}
		if ($msg->userid == $user->id){
			if($msg->delete()){
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
	public function actionLike() {
		$data = Yii::$app->request->post ();
		$user = new Users ();
		$phone=Users::find()->select('id')->where(['phone'=>$data['phone']])->one();
		//var_dump(Users::findOne(['phone'=>$data['phone']])['id']);
		$info = Tblikes::findOne ( [ 
				'userid' => $phone ['id'],
				'tbmessageid' => $data ['tbmessageid'] 
		] );
		if ($info) {
			echo json_encode ( array (
					'flag' => 0,
					'msg' => 'Already like!' 
			) );
		} else {
			$model = new Tblikes ();
			
			$model->userid = $phone ['id'];
			$model->tbmessageid = $data ['tbmessageid'];
			$model->created_at = time();
			
			
			//$model->save ();
			
			$tbmessage = $this->findModel($data['tbmessageid']);
			if(!$tbmessage){
				return array (
						'flag' => 0,
						'msg' => 'no tbmessage with this id!'
				);
			}
			$connection = Yii::$app->db;
			$transaction=$connection->beginTransaction();
			try {
					
				if(!$model->save())
					throw new Exception("dsfgsdfg");
				$tbmessage->likecount++;
				if(!$tbmessage->save())
					throw new Exception("asdfgsdfg");
				$transaction->commit();
			} catch (Exception $e) {
				$transaction->rollBack();
				//var_dump("133435465");
				//Yii::$app->log->logger->
				return 	array (
						//'error'=>$e,
						'flag' => 0,
						'msg' => 'like fail!'
				);
			}
			
			
			
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
					'msg' => 'like success!' 
			);
		}
	}
	public function actionCancellike() {
		$data = Yii::$app->request->post ();
	
		$user = new Users ();
		
		$phone = $user->find ()->select ( 'id' )->where ( [ 
				'phone' => $data ['phone'] 
		] )->one();
		$info = Tblikes::findOne ( [ 
				'userid' => $phone ['id'],
				'tbmessageid' => $data ['tbmessageid'] 
		] );
		$tbmessage = $this->findModel($data['tbmessageid']);
		if(!$tbmessage){
			return array (
					'flag' => 0,
					'msg' => 'no tbmessage with this id!'
			);
		}
		if ($info) {
			
			$connection = Yii::$app->db;
			$transaction=$connection->beginTransaction();
			try {	
				if(!$info->delete())
					throw new Exception("dsfgsdfg");
				$tbmessage->likecount--;
				if(!$tbmessage->save())
					throw new Exception("asdfgsdfg");
				$transaction->commit();
			} catch (Exception $e) {
				$transaction->rollBack();
				return 	array (
						//'error'=>$e,
						'flag' => 0,
						'msg' => 'Cancel fail!'
				);
			}
			return array (
					'flag' => 1,
					'msg' => 'Cancel success'
			);
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
		$model=new Tbreplys();
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
		$model->tbmessageid=$data['tbmessageid'];
		$model->content=$data['content'];
		$model->isread=0;
		$model->created_at=time();
		//var_dump($model);
		$tbmessage = $this->findModel($data['tbmessageid']);
		$connection = Yii::$app->db;
		$transaction=$connection->beginTransaction();
		try {
			
			if(!$model->save())
				throw new Exception("dsfgsdfg");
			$tbmessage->replycount++;
			if(!$tbmessage->save())
				throw new Exception("asdfgsdfg");
			$transaction->commit();
		} catch (Exception $e) {
    		$transaction->rollBack();
    		//var_dump("133435465");
    		//Yii::$app->log->logger->
    		return 	array (
    				//'error'=>$e,
    				'flag' => 0,
    				'msg' => 'Reply fail!'
    		);
    	}
    	return 	array (
    			'flag' => 1,
    			'msg' => 'Reply success!'
    	);

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
	protected function findModel($id)
	{
		if (($model = Tbmessages::findOne($id)) !== null) {
			return $model;
		}else {
			return false;
		}
	}
}
