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
use app\modules\v1\models\Traderecords;
use app\modules\v1\models\Consignment;
use yii\db\yii\db;

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
	public function actionTest(){
		$data=Yii::$app->request->post();
		$dirname = 'random/grabcommodities';
		if(!is_dir($dirname))
			mkdir($dirname,0777,true);
		$handle = fopen($dirname .'/'. $data['id'], "w+");
		$numbers = range (10000001,10000000+$data['count']);
		shuffle ($numbers);
		$string['numbers'] = $numbers;
		$string['begin']=0;
		$string = json_encode($string);
		fwrite($handle, $string);
		fclose($handle);
		return 	array (
				'count'=>$data['count'],
				'flag' => 1,
				'msg' => 'no enough arg!'
		);
	
	}
	public function actionTestopen(){
		$data=Yii::$app->request->post();
		$postdata = http_build_query(
    				array('grabcommodityid'=>$data['id'])
    		);
    		$opts = array('http' =>
    				array(
    						'method'  => 'POST',
    						'header'  => 'Content-type: application/x-www-form-urlencoded',
    						'content' => $postdata
    				)
    	
    		);
    		$context = stream_context_create($opts);
    		$result = file_get_contents('http://127.0.0.1:8888/commodityopen', false, $context);
		return 	array (
				'flag' => 1,
				'msg' => 'no enough arg!'
		);
	
	}
	public function actionTestbuy(){
		$data=Yii::$app->request->post();
		$dirname = 'random/grabcommodities';
		$lockfile = $dirname .'/'. $data['id'];
		$lock=new CacheLock($data['id'] );
		$lock->lock();
		$raw=file_get_contents($lockfile);
		$numbers=json_decode($raw,true);
		$arr2 = array_splice($numbers['numbers'],0, $data['count']);
		$usernumbers = join(' ', $arr2);
	
		file_put_contents($lockfile, json_encode($numbers));
		$lock->unlock();
		return 	array (
				'flag' => 1,
				'msg' => 'no enough arg!'
		);
	}
	public function actionGetthree(){
		$data=Yii::$app->request->post();
		return  (new \yii\db\Query ())->orderBy('date desc')->select('id,picture,kind,title,id as version,needed,remain,created_at,date,end_at,islotteried,winneruserid,winnerrecordid,winnernumber,foruser')->from('grabcommodities')->where('grabcommodities.islotteried = 0 and end_at = 0 and foruser = 0')->limit(3)->all();
	
	}
	public function actionSearch()
	{ 
// 		$data=Yii::$app->request->post();
		//$query = Grabcommodities::find()->where(['islotteried'=>0]);

		$data=Yii::$app->request->post();
		$query = (new \yii\db\Query ())->select('grabcommodities.id,picture,kind,title,grabcommodities.id as version,needed,remain,created_at,date,end_at,islotteried,winneruserid,winnerrecordid,winnernumber,foruser')->orderBy ( "grabcommodities.date desc" )->from('grabcommodities');
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
					'pagesize'=>5,
			],
		]);
		if(isset($data)&&isset($data['type'])){
			if($data['type']==0){
				$query->where('grabcommodities.islotteried = 0 and end_at = 0 and foruser = 0');
			}else if($data['type']==1){
				$query->where('grabcommodities.islotteried = 0 and end_at != 0 and foruser = 0');
			}else if($data['type']==2){
				//$query->where('grabcommodities.islotteried = 1 and end_at != 0 and foruser = 0')->orderBy ( "grabcommodities.end_at desc" );
				$query->select('grabcommodities.id,picture,kind,title,grabcommodities.id as version,needed,remain,grabcommodities.created_at,date,end_at,islotteried,winneruserid,winnerrecordid,winnernumber,foruser,users.phone,users.thumb,users.nickname,grabcommodityrecords.count')
				->where('grabcommodities.islotteried = 1 and end_at != 0 and foruser = 0')
				->join('INNER JOIN','users','users.id = grabcommodities.winneruserid')
				->join('INNER JOIN','grabcommodityrecords','grabcommodityrecords.id = grabcommodities.winnerrecordid')
				->orderBy('end_at desc');
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
		if(!(isset($data['kind']))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$query = (new \yii\db\Query ())->orderBy('date desc')
		->select('grabcommodities.*,grabcommodities.id as version,users.phone,users.thumb,users.nickname,grabcommodityrecords.numbers,grabcommodityrecords.count')
		->from('grabcommodities')
		->join('LEFT JOIN', 'grabcommodityrecords','grabcommodities.winnerrecordid = grabcommodityrecords.id')
		->leftJoin('users','grabcommodities.winneruserid=users.id')
		->orderBy('islotteried asc,end_at desc')
		->where('(islotteried!=0 or end_at=0) and kind = :kind',[':kind'=>$data['kind'],]);
		
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
		]);
		return $dataProvider;
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
		$grabcommodity = (new \yii\db\Query ())->select('grabcommodities.*,grabcommodities.id as version')->from('grabcommodities')->where(['id'=>$data['grabcommodityid']])->one();
		if(!$grabcommodity){
			return 	array (
					'flag' => 0,
					'msg' => 'no grabcommodity with this id!'
			);
		}
		if($grabcommodity['islotteried']){
			$s = (new \yii\db\Query ())->select('count,users.nickname,users.phone,users.thumb')->from('grabcommodityrecords,users')->where(['grabcommodityrecords.id'=>$grabcommodity['winnerrecordid'],'users.id'=>$grabcommodity['winneruserid']])->one();
			$grabcommodity=array_merge($grabcommodity,$s);
		}
		$records = (new \yii\db\Query ())->select ( [
				'grabcommodityrecords.count',
				'grabcommodityrecords.id',
				'grabcommodityrecords.created_at',
				'users.phone',
				'users.nickname',
				'users.thumb'
		] )
		->from ( 'grabcommodityrecords' )
		->orderBy('grabcommodityrecords.created_at desc')
		->join ( 'INNER JOIN', 'users', 'grabcommodityrecords.userid = users.id and grabcommodityrecords.grabcommodityid = :id', [
				':id' => $grabcommodity['id']
		] )
		->limit(5)
		->all ();
		$myrecords = (new \yii\db\Query ())->select ( [
				'grabcommodityrecords.*',
				'users.phone',
				'users.nickname',
				'users.thumb'
		] )->from ( 'grabcommodityrecords' )->orderBy('grabcommodityrecords.created_at desc')->join ( 'INNER JOIN', 'users', 'grabcommodityrecords.userid = users.id and users.phone = :phone and grabcommodityrecords.grabcommodityid = :id', [
				':id' => $grabcommodity['id'],':phone'=>$data['phone']
		] )->all ();
		foreach ($myrecords as $i=> $item){
			
			if(strlen($item['numbers'])>35)
				$myrecords[$i]['numbers'] = substr($myrecords[$i]['numbers'],0,35);
		}
		$result['detail'] = $grabcommodity;
		$result['records'] = $records;
		$result['myrecords']=$myrecords;
		return $result;
	}
	
	public function actionLast50()
	{
		$data=Yii::$app->request->post();
		if(!(isset($data['grabcommodityid']))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$grabcommodity = (new \yii\db\Query ())->select('grabcommodities.*,grabcommodities.id as version')->from('grabcommodities')->where(['id'=>$data['grabcommodityid']])->one();
		if(!$grabcommodity){
			return 	array (
					'flag' => 0,
					'msg' => 'no grabcommodity with this id!'
			);
		}
		$records = (new \yii\db\Query ())->select ( [
				'grabcommodityrecords.count',
				'grabcommodityrecords.id',
				'grabcommodityrecords.created_at',
				'users.phone',
				'users.nickname',
				'users.thumb'
		] )
		->from ( 'grabcommodityrecords' )
		->orderBy('grabcommodityrecords.created_at desc')
		->join ( 'INNER JOIN', 'users', 'grabcommodityrecords.userid = users.id'
		)
		->limit(50)
		->where('grabcommodityrecords.created_at < '.$grabcommodity['end_at'])
		->all ();
		
		return $records;
	}
	
	public function actionMorerecords(){
		$data=Yii::$app->request->post();
		if(!(isset($data['grabcommodityid']))){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		$query=(new \yii\db\Query ())->select ( [
				'grabcommodityrecords.count',
				'grabcommodityrecords.id',
				'grabcommodityrecords.created_at',
				'users.phone',
				'users.nickname',
				'users.thumb'
		] )->from ( 'grabcommodityrecords' )->orderBy('grabcommodityrecords.created_at desc')->join ( 'INNER JOIN', 'users', 'grabcommodityrecords.userid = users.id and grabcommodityrecords.grabcommodityid = :id', [
				':id' => $data['grabcommodityid']
		] );
		// = (new \yii\db\Query ())->orderBy('date desc')->select('grabcorns.*')->from('grabcorns');
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination'=>[
						'pagesize' => '5',
				]
		]);
		return $dataProvider;
	}
    /**
     * Creates a new Applyjobs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	
        
        $data=Yii::$app->request->post();
        //var_dump(isset($date['content']);
        return $this->create($data);
    }
	private function create($data){
		$model = new Grabcommodities();
		if(!(isset($data['picture'])&&isset($data['title'])&&isset($data['version'])&&isset($data['needed'])&&isset($data['date'])&&isset($data['kind'])&&isset($data['worth']))){
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
			$dirname = 'random/grabcommodities';
			if(!is_dir($dirname))
				mkdir($dirname,0777,true);
			$handle = fopen($dirname .'/'. $model['id'], "w+");
			$numbers = range (10000001,10000000+$model->needed);
			shuffle ($numbers);
			$string['numbers'] = $numbers;
			$string['begin']=0;
			$string = json_encode($string);
			fwrite($handle, $string);
			fclose($handle);
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
    	
    	$dirname = 'random/grabcommodities';
    	$lockfile = $dirname .'/'. $data['grabcommodityid'];
    	$lock=new CacheLock('grabcommodity'.$data['grabcommodityid'] );
    	$lock->lock();
    	$raw=file_get_contents($lockfile);
    	$numbers=json_decode($raw,true);
    	$arr2 = array_splice($numbers['numbers'],0, $data['count']);
    	$usernumbers = join(' ', $arr2);
    	
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
    			case 1://jinbi
    				$updatemoney=$connection->createCommand('update users set corns = corns-:count where id = :userid and corns>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				//$updatemoney=$connection->createCommand('update users set cornsforgrab = cornsforgrab-:count where id = :userid and cornsforgrab>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 2://duobaobi
    				$updatemoney=$connection->createCommand('update users set cornsforgrab = cornsforgrab-:count where id = :userid and cornsforgrab>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				//$updatemoney=$connection->createCommand('update users set envelope = envelope-:count where id = :userid and envelope>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 3://jinbi
    				break;
    		}
    		//$updatemoney=$connection->createCommand('update users set ')->execute();
    		$inserrecord=$connection->createCommand('insert into grabcommodityrecords(userid,grabcommodityid,count,numbers,type,created_at) values (:userid,:grabcommodityid,:count,:numbers,:type,:created_at)'
    					,[':userid'=>$user->id,':grabcommodityid'=>$data['grabcommodityid'],':count'=>$data['count'],':numbers'=>$usernumbers,':type'=>$data['type'],':created_at'=>microtime(true)])->execute();
    		//var_dump($expression)
    		if($data['type']==0){
    			$inserttrade = $connection->createCommand('insert into traderecords(userid,count,type,description,cardid,created_at) values (:userid,:count,:type,:description,:cardid,:created_at)'
    					,[':userid'=>$user->id,':count'=>$data['count'],':type'=>-2,'description'=>'购买' . $grabcommodity->title .'第'.$grabcommodity->version .'期',':cardid'=>0,':created_at'=>time()])->execute();
    			 //var_dump($inserttrade);
    			 if(!$inserttrade){
    			 	throw new Exception("insert trade record fail");
    			 }
    		}
    		
    		if(!(($data['type']==3||$updatemoney)&&$updatecount&&$inserrecord)){
    			throw new Exception("Value must be 1 or below");
    		}
    		// ... executing other SQL statements ...
    		$transaction->commit();
    	} catch (Exception $e) {
    		$transaction->rollBack();
    		var_dump($e->getMessage());
    		//Yii::$app->log->logger->
    		$lock->unlock();
    		return 	array (
    				'flag' => 0,
    				'msg' => 'buy fail!'
    		);
    	}
    	file_put_contents($lockfile, json_encode($numbers));
    	$lock->unlock();
    	$grabcommodity = Grabcommodities::findOne(['id'=>$data['grabcommodityid']]);
    	$result="";
    	if($grabcommodity->remain==0){
    		//if(!(isset($data['picture'])&&isset($data['title'])&&isset($data['version'])&&isset($data['needed'])&&isset($data['date'])&&isset($data['kind'])&&isset($data['worth']))){
    		
    		$result=$this->create(array(
    				'picture'=>$grabcommodity->picture,
    				'details'=>$grabcommodity->details,
    				'pictures'=>$grabcommodity->pictures,
    				'title'=>$grabcommodity->title,
    				'version'=>strval($grabcommodity->version+1),
    				'needed'=>$grabcommodity->needed,
    				'date'=>time(),
    				'kind'=>$grabcommodity->kind,
    				'worth'=>$grabcommodity->worth,
    		));
    		
    		//return $result;
    		$grabcommodity->end_at = time()+10*60;
    		$grabcommodity->save();
    		//curl_setopt ($ch, CURLOPT_URL, "http://127.0.0.1:8888/test");
    		$postdata = http_build_query(
    				array('grabcommodityid'=>$grabcommodity->id)
    		);
    		$opts = array('http' =>
    				array(
    						'method'  => 'POST',
    						'header'  => 'Content-type: application/x-www-form-urlencoded',
    						'content' => $postdata
    				)
    	
    		);
    		$context = stream_context_create($opts);
    		$result = file_get_contents('http://127.0.0.1:8888/commodityopen', false, $context);
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
    			case 1://jinbi
    				$updatemoney=$connection->createCommand('update users set corns = corns-:count where id = :userid and corns>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				//$updatemoney=$connection->createCommand('update users set cornsforgrab = cornsforgrab-:count where id = :userid and cornsforgrab>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 2://duobaobi
    				$updatemoney=$connection->createCommand('update users set cornsforgrab = cornsforgrab-:count where id = :userid and cornsforgrab>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				//$updatemoney=$connection->createCommand('update users set envelope = envelope-:count where id = :userid and envelope>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 3://jinbi
    				break;
    		}
    		//$updatemoney=$connection->createCommand('update users set ')->execute();
    		$insertgrab=$connection->createCommand('insert into grabcommodities(picture,title,version,needed,remain,created_at,date,end_at,islotteried,winneruserid,foruser,kind,pictures,details,worth) select picture,title,version,needed,0,created_at,:time,:time,1,:userid,:userid,kind,pictures,details,worth from grabcommodities where id = :grabcommodityid',[':time'=>$time,':userid'=>$user->id,':grabcommodityid'=>$data['grabcommodityid']])->execute();
    		//$insertgrabid=mysql_insert_id($connection);
    		$insertgrabid=$connection->getLastInsertID();
    		//var_dump($insertgrab);
    		//var_dump($insertgrabid);
    		$inserrecord=$connection->createCommand('insert into grabcommodityrecords(userid,grabcommodityid,count,numbers,type,created_at) values (:userid,:grabcommodityid,:count,:numbers,:type,:created_at)'
    				,[':userid'=>$user->id,':grabcommodityid'=>$insertgrabid,':count'=>$grabcommodity->needed,':numbers'=>"",':type'=>$data['type'],':created_at'=>microtime(true)])->execute();
    		$insertrid=$connection->getLastInsertID();
    		$updategrab=$connection->createCommand('update grabcommodities set winnerrecordid=:recordid where grabcommodities.id = :id',['recordid'=>$insertrid,':id'=>$insertgrabid])->execute();
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
    public function actionGetcommodity(){
    	$data=Yii::$app->request->post();
    	if(!(isset($data['phone'])&&isset($data['grabcommodityid'])&&isset($data['addressid']))){
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
    	$user = Users::findOne(['phone'=>$data['phone']]);
    	if(!$user){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'find user fail!'
    		);
    	}
    	if($grabcommodity->winneruserid !=$user->id){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'you are not the winner!'
    		);
    	}
    	 
    	if($grabcommodity->isgot !=0){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'you has got the commodity!'
    		);
    	}
    	 
    	$connection = Yii::$app->db;
    	$transaction=$connection->beginTransaction();
    	$updategrab=0;
    	try {
    		$updategrab=$connection->createCommand('update grabcommodities g1 set g1.isgot=1 where g1.id=:id',[':id'=>$data['grabcommodityid']])->execute();
    		//$insertwait=$connection->createCommand('update $grabcommodities g1 set g1.isgot=1 where g1.id=:id',[':id'=>$data['grabcommodityid']])->execute();
    		if(!($updategrab)){
    			throw new Exception("Value must be 1 or below");
    		}
    		
    		$con = new Consignment();
                $con['grabcommodityid'] = $grabcommodity['id'];
                $con['addressid'] = $data['addressid'];
                $con['created_at'] = time();
                $con['status'] = 0;
                if(!$con->save()){
                	var_dump($con->errors);
                        throw new Exception($con->errors);
                }
    		// ... executing other SQL statements ...
    		$transaction->commit();
    
    	} catch (Exception $e) {
    		$transaction->rollBack();
    		//var_dump($e->getMessage());
    		//Yii::$app->log->logger->
    		return 	array (
    				'error'=>$e->getMessage(),
    				'flag' => 0,
    				'msg' => 'get commodity fail!'
    		);
    	}
    	return 	array (
    			'flag' => 1,
    			'msg' => 'get commodity success!'
    	);
    }
    
    public function actionChangetocorns(){
    	$data=Yii::$app->request->post();
    	if(!(isset($data['phone'])&&isset($data['grabcommodityid']))){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	//Users::findOne(['phone'=>$data['phone']])
    	$grabcommodity = Grabcorns::findOne(['id'=>$data['grabcommodityid']]);
    	 
    	if(!$grabcommodity){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'activity not exist!'
    		);
    	}
    	$user = Users::findOne(['phone'=>$data['phone']]);
    	if(!$user){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'find user fail!'
    		);
    	}
    	if($grabcommodity->winneruserid !=$user->id){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'you are not the winner!'
    		);
    	}
    	 
    	if($grabcommodity->isgot !=0){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'you has got the corn!'
    		);
    	}
    	 
    	$connection = Yii::$app->db;
    	$transaction=$connection->beginTransaction();
    	$updategrab=0;
    	try {
    		//$worth = intval($grabcommodity->worth * 0.9);
    		$updategrab=$connection->createCommand('update grabcommodities g1,users u1 set g1.isgot=1,u1.corns=u1.corns+g1.worth where g1.id=:id and u1.id = g1.winneruserid',[':id'=>$data['grabcommodityid']])->execute();
    
    		if(!($updategrab)){
    			throw new Exception("Value must be 1 or below");
    		}
    		// ... executing other SQL statements ...
    		$transaction->commit();
    
    	} catch (Exception $e) {
    		$transaction->rollBack();
    		//var_dump($e->getMessage());
    		//Yii::$app->log->logger->
    		return 	array (
    				'err'=>$e,
    				'flag' => 0,
    				'msg' => 'get grabcommodity fail!'
    		);
    	}
    	return 	array (
    			'c'=>$updategrab,
    			'flag' => 1,
    			'msg' => 'get grabcommodity success!'
    	);
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
