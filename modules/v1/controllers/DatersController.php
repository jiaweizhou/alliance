<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Daters;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\Users;
use app\modules\v1\models\app\modules\v1\models;

/**
 * ApplyjobsController implements the CRUD actions for Applyjobs model.
 */
class DatersController extends Controller
{
	public $modelClass = 'app\modules\v1\models\Daters';
	public $serializer = [
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items'
	];
  
    /**
     * Lists all Applyjobs models.
     * @return mixed
     */

	public function actionSearch()
	{ 
		$data=Yii::$app->request->post();
		
		$longitude = $data['longitude'];
		$latitude = $data['latitude'];
		
		$query = (new \yii\db\Query ())
		->select('daters.*,users.phone,users.nickname,users.thumb,hobbies.hobby')
		->from('daters')
		->orderBy(sprintf('abs(daters.longitude - %f) + abs(daters.latitude - %f) desc',$longitude,$latitude))
		->join('INNER JOIN','users','daters.userid = users.id')
		->join('INNER JOIN','hobbies','daters.hobbyid = hobbies.id');
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
		]);
		//$this->load($params);
		//$value = 0;
		if(!empty($data)){
			if(isset($data['phone'])){
					$query->andFilterWhere(['users.phone' => $data['phone']]);
			}
			
			if(isset($data['hobbyid'])){
				$query->andFilterWhere(['hobbyid' => $data['hobbyid']]);
			}
			if(isset($data['content'])){
				$query->andFilterWhere(['like', 'content',$data['content']]);
			}
		}
		
		$daters = $dataProvider->getModels();
		//$result = array ();
		//$result ['item'] = array ();
		
		//$tbreplys = (new \yii\db\Query ())->select('tbreplys.*,users.phone,users.nickname,users.thumb')->orderBy ( "tbreplys.created_at desc" )->join ( 'INNER JOIN', 'users', ' tbmessages.userid =users.id ')->where('tbreplys.messageid in ');
		
		foreach ( $daters as $i=>$dater ) {
			$info = $dater;
			
			$info["distance"] = $this->getDistance($latitude, $longitude, $info['latitude'], $info['longitude']);
		
			$daters[$i] = $info;
		
		}
		$dataProvider->setModels($daters);
		
		return $dataProvider;
	}
	function getDistance($lat1, $lng1, $lat2, $lng2)
	{
		$earthRadius = 6367000; //approximate radius of earth in meters
	
		/*
		 Convert these degrees to radians
		 to work with the formula
		 */
	
		$lat1 = ($lat1 * pi() ) / 180;
		$lng1 = ($lng1 * pi() ) / 180;
	
		$lat2 = ($lat2 * pi() ) / 180;
		$lng2 = ($lng2 * pi() ) / 180;
	
		/*
		 Using the
		 Haversine formula
	
		 http://en.wikipedia.org/wiki/Haversine_formula
	
		 calculate the distance
		 */
	
		$calcLongitude = $lng2 - $lng1;
		$calcLatitude = $lat2 - $lat1;
		$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
		$calculatedDistance = $earthRadius * $stepTwo;
	
		return round($calculatedDistance)/1000;
	}
    /**
     * Creates a new Applyjobs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	
        $model = new Daters();
        $data=Yii::$app->request->post();
        //var_dump(isset($date['content']);
        if(!(isset($data['phone'])&&isset($data['picture'])&&isset($data['sex'])&&isset($data['age'])&&isset($data['hobbyid'])&&isset($data['content']))){
        	return 	array (
        			'flag' => 0,
        			'msg' => 'no enough arg!'
        	);
        }
        
        $user = Users::findOne(['phone'=>$data['phone']]);
        if(!$user){
        	return 	array (
        			'flag' => 0,
        			'msg' => 'create dater fail!'
        	);
        }
        $data['userid'] = $user->id;
        $data['created_at'] = time();
        foreach ($model->activeAttributes() as $item){
        	$model->$item = $data[$item];
        }
        if ($model->save()) {
            return 	array (
        			'flag' => 1,
        			'msg' => 'create dater success!'
        	);
        } else {
        	//var_dump($model->errors);
            return 	array (
        			'flag' => 0,
        			'msg' => 'create dater fail!'
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
    	if(!isset($data['phone'])||!isset($data['daterid'])){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	$user = Users::findOne(['phone'=>$data['phone']]);
    	$dater=$this->findModel($data['daterid']);
    	if (!$dater||!$user){
    		return  array (
    				'flag' => 0,
    				'msg' => 'update dater fail!'
    		);
    	}
    	if ($dater->userid != $user->id){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'have no authority!'
    		);
    	}
        //$model = $this->findModel($id);
		unset($data['phone']);
		unset($data['daterid']);
		
		foreach ($data as $item=>$arg ){
			$dater->$item = $arg;
		}
		
        if ($dater->save()) {
            return 	array (
        			'flag' => 1,
        			'msg' => 'update dater success!'
        	);
        } else {
            return  array (
    				'flag' => 0,
    				'msg' => 'update dater fail!'
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
    	if(!isset($data['phone'])||!isset($data['daterid'])){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	$user = Users::findOne(['phone'=>$data['phone']]);
        $dater=$this->findModel($data['daterid']);
        if (!$dater||!$user){
        	return  array (
						'flag' => 0,
						'msg' => 'delete dater fail!'
				);
        }
		if ($dater->userid == $user->id){
			if($dater->delete()){
				return 	array (
						'flag' => 1,
						'msg' => 'delete dater success!'
				);
			}else{
				return 	array (
						'flag' => 0,
						'msg' => 'delete dater fail!'
				);
			}
		}else{
			return 	array (
					'flag' => 0,
					'msg' => 'have no authority!'
			);
		}
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
        if (($model = Daters::findOne($id)) !== null) {
            return $model;
        }else {
        	return false;
        }
    }
}
