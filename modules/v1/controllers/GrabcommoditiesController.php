<?php

namespace app\modules\v1\controllers;

use Yii;
use Exception;
use app\modules\v1\models\Grabcommodities;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\Users;
use app\modules\v1\models\app\modules\v1\models;

/**
 * ApplyjobsController implements the CRUD actions for Applyjobs model.
 */
class GrabcommoditiesController extends Controller
{
	public $modelClass = 'app\modules\v1\models\Grabcommodities';
	public $serializer = [
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items'
	];
  
    /**
     * Lists all Applyjobs models.
     * @return mixed
     */
	public function actionGetthree(){
		$data=Yii::$app->request->post();
		return  (new \yii\db\Query ())->orderBy('date desc')->select('id,picture,kind,title,version,needed,remain,created_at,date,end_at,islotteried,winneruserid,winnerrecordid,winnernumber,foruser')->from('grabcommodities')->where('grabcommodities.islotteried = 0 and end_at = 0 and foruser = 0')->limit(3)->all();
	
	}
	public function actionSearch()
	{ 
// 		$data=Yii::$app->request->post();
		//$query = Grabcommodities::find()->where(['islotteried'=>0]);

		$data=Yii::$app->request->post();
		$query = (new \yii\db\Query ())->select('id,picture,kind,title,version,needed,remain,created_at,date,end_at,islotteried,winneruserid,winnerrecordid,winnernumber,foruser')->orderBy ( "grabcommodities.date desc" )->from('grabcommodities');
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		if(isset($data)&&isset($data['type'])){
			if($data['type']==0){
				$query->where('grabcommodities.islotteried = 0 and end_at = 0 and foruser = 0');
			}else if($data['type']==1){
				$query->where('grabcommodities.islotteried = 0 and end_at != 0 and foruser = 0');
			}else if($data['type']==2){
				$query->where('grabcommodities.islotteried = 1 and end_at != 0 and foruser = 0');
			}
		}
		
		return $dataProvider;
// 		$dataProvider = new \yii\data\Pagination ( [
// 				'totalCount' => $query->count (),
// 				'pageSize' => '20'
// 		] );
//		$models = $query->orderBy ( "grabcommodities.date desc" )->offset ( $dataProvider->offset )->limit ( $dataProvider->limit )->all ();
		//var_dump($models);
//		$result['items'] =array();
// 		foreach ( $models as $model ) {
// 			$comments = (new \yii\db\Query ())->select ( [
// 					'grabcommodityrecords.*',
// 					'users.phone',
// 					'users.nickname',
// 					'users.thumb'
// 			] )->from ( 'grabcommodityrecords' )->orderBy('grabcommodityrecords.created_at desc')->join ( 'INNER JOIN', 'users', 'grabcommodityrecords.userid = users.id and grabcommodityrecords.grabcommodityid = :id', [
// 					':id' => $model ['id']
// 			] )->all ();
// 			$model['comments'] = $comments;
// 			$result['items'][]=$model;
// 		}
		//$result['items'] = $models;
// 		$result['_meta'] = array(
// 				'totalCount'=>$dataProvider->totalCount,
// 				'pageCount'=>$dataProvider->pageCount,
// 				'currentPage'=>$dataProvider->page+1,
// 				'perPage'=>$dataProvider->pageSize,
// 		);
		//$dataProvider->on($name, $handler)
		//$dataProvider->
//		return $result;

		
	}
	public function actionFormeractivities(){
		$data=Yii::$app->request->post();
		if(!(isset($data['phone'])&&isset($data['grabcommodityid']))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
	}
	public function actionView()
	{
		$data=Yii::$app->request->post();
		if(!(isset($data['phone'])&&isset($data['grabcommodityid']))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$grabcommodity = (new \yii\db\Query ())->select('grabcommodities.*')->from('grabcommodities')->where(['id'=>$data['grabcommodityid']])->one();
		if(!$grabcommodity){
			return 	array (
					'flag' => 0,
					'msg' => 'no grabcommodity with this id!'
			);
		}
		$records = (new \yii\db\Query ())->select ( [
				'grabcommodityrecords.*',
				'users.phone',
				'users.nickname',
				'users.thumb'
		] )->from ( 'grabcommodityrecords' )->orderBy('grabcommodityrecords.created_at desc')->join ( 'INNER JOIN', 'users', 'grabcommodityrecords.userid = users.id and grabcommodityrecords.grabcommodityid = :id', [
				':id' => $grabcommodity['id']
		] )->all ();
		$myrecords = (new \yii\db\Query ())->select ( [
				'grabcommodityrecords.*',
				'users.phone',
				'users.nickname',
				'users.thumb'
		] )->from ( 'grabcommodityrecords' )->orderBy('grabcommodityrecords.created_at desc')->join ( 'INNER JOIN', 'users', 'grabcommodityrecords.userid = users.id and users.phone = :phone and grabcommodityrecords.grabcommodityid = :id', [
				':id' => $grabcommodity['id'],':phone'=>$data['phone']
		] )->all ();
		$result['detail'] = $grabcommodity;
		$result['records'] = $records;
		$result['myrecords']=$myrecords;
		return $result;
	}
	
    /**
     * Creates a new Applyjobs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	
        $model = new Grabcommodities();
        $data=Yii::$app->request->post();
        //var_dump(isset($date['content']);
        if(!(isset($data['picture'])&&isset($data['title'])&&isset($data['version'])&&isset($data['needed'])&&isset($data['date'])&&isset($data['kind']))){
        	return 	array (
        			'flag' => 0,
        			'msg' => 'no enough arg!'
        	);
        }
        
        $data['created_at'] = time();
        $data['end_at'] = 0;
        $data['remain'] = $data['needed'];
        foreach ($data as $item=>$value){
        	$model->$item = $data[$item];
        }
        if ($model->save()) {
            return 	array (
        			'flag' => 1,
        			'msg' => 'create grabcommodity success!'
        	);
        } else {
        	//var_dump($model->errors);
            return 	array (
            		'error'=> $model->errors,
        			'flag' => 0,
        			'msg' => 'create grabcommodity fail!'
        	);
        }
    }

    /**
     * Updates an existing Applyjobs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
    	$data=Yii::$app->request->post();
    	if(!isset($data['grabcommodityid'])){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	$grabcommodity=$this->findModel($data['grabcommodityid']);
    	if (!$grabcommodity){
    		return  array (
    				'flag' => 0,
    				'msg' => 'update grabcommodity fail!'
    		);
    	}
        //$model = $this->findModel($id);
		//unset($data['phone']);
		unset($data['grabcommodityid']);
		
		foreach ($data as $item=>$arg ){
			$grabcommodity->$item = $arg;
		}
		
        if ($grabcommodity->save()) {
            return 	array (
        			'flag' => 1,
        			'msg' => 'update grabcommodity success!'
        	);
        } else {
            return  array (
    				'flag' => 0,
    				'msg' => 'update grabcommodity fail!'
    		);
        }
    }

    /**
     * Deletes an existing Applyjobs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
    	$data=Yii::$app->request->post();
    	if(!isset($data['grabcommodityid'])){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	
        $grabcommodity=$this->findModel($data['grabcommodityid']);
        if (!$grabcommodity){
        	return  array (
						'flag' => 0,
						'msg' => 'delete grabcommodity fail!'
				);
        }
		if($grabcommodity->delete()){
			return 	array (
					'flag' => 1,
					'msg' => 'delete grabcommodity success!'
			);
		}else{
			return 	array (
					'flag' => 0,
					'msg' => 'delete grabcommodity fail!'
			);
		}
    }

    
    public function actionBuy(){
    	$data=Yii::$app->request->post();
    	if(!(isset($data['phone'])&&isset($data['grabcommodityid'])&&isset($data['count'])&&isset($data['type']))){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	//Users::findOne(['phone'=>$data['phone']])
    	$grabcommodity = Grabcommodities::findOne(['id'=>$data['grabcommodityid']]);
    	if(!$grabcommodity){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'activity not exist!'
    		);
    	}
//     	}else if ($grabcorn->end_at < time()){
//     		return 	array (
//     				'flag' => 0,
//     				'msg' => 'activity is end!'
//     		);
//     	}
    	$user = Users::findOne(['phone'=>$data['phone']]);
    	if(!$user){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'find user fail!'
    		);
    	}
    	
    	$updatecount = 0;
    	$inserrecord = 0;
    	$updatemoney = 0;
    	for ($i = 0; $i < $data['count']; $i++) {
    		
    	}
    	$connection = Yii::$app->db;
    	$transaction=$connection->beginTransaction();
    	try {
    		
    		$connection->createCommand('select * from grabcommodities where id=:id for update',[':id'=>$data['grabcommodityid'],':count'=>$data['count']]);
    		$connection->createCommand('select * from users where id=:id for update',[':id'=>$data['grabcommodityid'],':count'=>$data['count']]);
    		$updatecount=$connection->createCommand('update grabcommodities set remain=remain-:count where id=:id and remain>=:count',[':id'=>$data['grabcommodityid'],':count'=>(int)$data['count']])->execute();
    		switch ($data['type']){
    			case 0://yuer
    				$updatemoney=$connection->createCommand('update users set money = money-:count where id = :userid and money>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 1://duojinbi
    				//$updatemoney=$connection->createCommand('update users set cornsforgrab = cornsforgrab-:count where id = :userid and cornsforgrab>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 2://hongbao
    				$updatemoney=$connection->createCommand('update users set envelope = envelope-:count where id = :userid and envelope>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 3://jinbi
    				$updatemoney=$connection->createCommand('update users set corns = corns-:count where id = :userid and corns>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();	
    				break;
    			case 4://zhifupintai
    				
    				break;
    		}
    		//$updatemoney=$connection->createCommand('update users set ')->execute();
    		$inserrecord=$connection->createCommand('insert into grabcommodityrecords(userid,grabcommodityid,count,numbers,type,created_at) values (:userid,:grabcommodityid,:count,:numbers,:type,:created_at)'
    					,[':userid'=>$user->id,':grabcommodityid'=>$data['grabcommodityid'],':count'=>$data['count'],':numbers'=>"",':type'=>$data['type'],':created_at'=>time()])->execute();
    		//var_dump($expression)
    		if(!(($data['type']==4||$updatemoney)&&$updatecount&&$inserrecord)){
    			throw new Exception("Value must be 1 or below");
    		}
    		// ... executing other SQL statements ...
    		$transaction->commit();
    	} catch (Exception $e) {
    		$transaction->rollBack();
    		var_dump($e->getMessage());
    		//Yii::$app->log->logger->
    		return 	array (
    				'flag' => 0,
    				'msg' => 'buy fail!'
    		);
    	}
    	return 	array (
    			'flag' => 1,
    			'msg' => 'buy success!'
    	);
    	//$transaction = $connection->beginTransaction();
    	//Grabcorns::updateAllCounters([left=> -$data['count']],)
    }
    
    
    public function actionBuyall(){
    	$time = time();
    	$data=Yii::$app->request->post();
    	if(!(isset($data['phone'])&&isset($data['grabcommodityid'])&&isset($data['type']))){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	//Users::findOne(['phone'=>$data['phone']])
    	$grabcommodity = Grabcommodities::findOne(['id'=>$data['grabcommodityid']]);
    	
    	if(!$grabcommodity){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'activity not exist!'
    		);
    	}
//     	}else if ($grabcorn->end_at < time()){
//     		return 	array (
//     				'flag' => 0,
//     				'msg' => 'activity is end!'
//     		);
//     	}
    	$data['count'] = $grabcommodity->needed;
    	$user = Users::findOne(['phone'=>$data['phone']]);
    	if(!$user){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'find user fail!'
    		);
    	}
    	 
    	$insertgrab = 0;
    	$inserrecord = 0;
    	$updatemoney = 0;
    	$updategrab = 0;
    	for ($i = 0; $i < $data['count']; $i++) {
    
    	}
    	$connection = Yii::$app->db;
    	$transaction=$connection->beginTransaction();
    	try {
    
    		//$connection->createCommand('select * from grabcorns where id=:id for update',[':id'=>$data['grabcommodityid'],':count'=>$data['count']]);
    		$connection->createCommand('select * from users where id=:id for update',[':id'=>$data['grabcommodityid'],':count'=>$data['count']]);
    		//$updatecount=$connection->createCommand('update grabcorns set remain=remain-:count where id=:id and remain>=:count',[':id'=>$data['grabcommodityid'],':count'=>(int)$data['count']])->execute();
    		switch ($data['type']){
    			case 0://yuer
    				$updatemoney=$connection->createCommand('update users set money = money-:count where id = :userid and money>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 1://duojinbi
    				//$updatemoney=$connection->createCommand('update users set cornsforgrab = cornsforgrab-:count where id = :userid and cornsforgrab>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 2://hongbao
    				$updatemoney=$connection->createCommand('update users set envelope = envelope-:count where id = :userid and envelope>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 3://jinbi
    				$updatemoney=$connection->createCommand('update users set corns = corns-:count where id = :userid and corns>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 4://zhifupintai
    				break;
    		}
    		//$updatemoney=$connection->createCommand('update users set ')->execute();
    		$insertgrab=$connection->createCommand('insert into grabcommodities(picture,title,version,needed,remain,created_at,date,end_at,islotteried,winneruserid,foruser,kind) select picture,title,version,needed,0,created_at,:time,:time,1,:userid,:userid,kind from grabcommodities where id = :grabcommodityid',[':time'=>$time,':userid'=>$user->id,':grabcommodityid'=>$data['grabcommodityid']])->execute();
    		//$insertgrabid=mysql_insert_id($connection);
    		$insertgrabid=$connection->getLastInsertID();
    		//var_dump($insertgrab);
    		//var_dump($insertgrabid);
    		$inserrecord=$connection->createCommand('insert into grabcommodityrecords(userid,grabcommodityid,count,numbers,type,created_at) values (:userid,:grabcommodityid,:count,:numbers,:type,:created_at)'
    				,[':userid'=>$user->id,':grabcommodityid'=>$insertgrabid,':count'=>$grabcommodity->needed,':numbers'=>"",':type'=>$data['type'],':created_at'=>time()])->execute();
    		$insertrid=$connection->getLastInsertID();
    		$updategrab=$connection->createCommand('update grabcommodities set winnerrecordid=:recordid where grabcommodities.id = :id',['recordid'=>$insertrid,':id'=>$data['grabcommodityid']])->execute();
    		//var_dump($expression)
    		if(!(($data['type']==4||$updatemoney)&&$inserrecord&&$insertgrab&&$updategrab)){
    			throw new Exception("Value must be 1 or below");
    		}
    		// ... executing other SQL statements ...
    		$transaction->commit();
    	} catch (Exception $e) {
    		$transaction->rollBack();
    		//var_dump($e->getMessage());
    		//Yii::$app->log->logger->
    		return 	array (
    				'flag' => 0,
    				'msg' => 'buy fail!'
    		);
    	}
    	return 	array (
    			'flag' => 1,
    			'msg' => 'buy success!'
    	);
    	//$transaction = $connection->beginTransaction();
    	//Grabcorns::updateAllCounters([left=> -$data['count']],)
    }
    
    
    /**
     * Finds the Applyjobs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Applyjobs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grabcommodities::findOne($id)) !== null) {
            return $model;
        }else {
        	return false;
        }
    }
}
