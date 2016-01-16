<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Applyjobs;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\Users;

/**
 * ApplyjobsController implements the CRUD actions for Applyjobs model.
 */
class ApplyjobsController extends Controller
{
	public $modelClass = 'app\modules\v1\models\Applyjobs';
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
		->select('applyjobs.*,users.phone,users.nickname,users.thumb,professions.profession')
		->from('applyjobs')
		->orderBy(sprintf('abs(applyjobs.longitude - %f) + abs(applyjobs.latitude - %f)',$longitude,$latitude))
		->join('INNER JOIN','users','applyjobs.userid = users.id')
		->join('INNER JOIN','professions','applyjobs.professionid = professions.id');
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
		]);
		//$this->load($params);
		//$value = 0;
		if(!empty($data)){
			if(isset($data['phone'])){
					$query->andFilterWhere(['users.phone' => $data['phone']]);
			}
			
			if(isset($data['professionid'])){
				$query->andFilterWhere(['professionid' => $data['professionid']]);
			}
			if(isset($data['jobproperty'])){
				$query->andFilterWhere(['jobproperty' => $data['jobproperty']]);
			}
			if(isset($data['title'])){
				$query->andFilterWhere(['like', 'title',$data['title']]);
			}
		}	
		
		$applyjobs = $dataProvider->getModels();
		
		foreach ( $applyjobs as $i=>$applyjob ) {
			$info = $applyjob;
				
			$info["distance"] = $this->getDistance($latitude, $longitude, $info['latitude'], $info['longitude']);
		
			$applyjobs[$i] = $info;
		
		}
		$dataProvider->setModels($applyjobs);
		
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
	
		return round($calculatedDistance);
	}
    public function actionMy()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Applyjobs::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Applyjobs model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Applyjobs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Applyjobs();
        $data=Yii::$app->request->post();
        $user = Users::findOne(['phone'=>$data['phone']]);
        if(!$user){
        	return 	array (
        			'flag' => 0,
        			'msg' => 'create job applying fail!'
        	);
        }
        $model->jobproperty = isset($data['jobproperty'])?$data['jobproperty']:0;
        $model->title = isset($data['title'])?$data['title']:'';
        $model->degree = isset($data['degree'])?$data['degree']:0;
        $model->work_at = isset($data['work_at'])?$data['work_at']:'';
        $model->status = isset($data['status'])?$data['status']:'';
        $model->hidephone = isset($data['hidephone'])?$data['hidephone']:0;
        $model->content = isset($data['content'])?$data['content']:'';
        $model->professionid = isset($data['professionid'])?$data['professionid']:0;
        $model->herphone = isset($data['herphone'])?$data['herphone']:0;
        
        //$model->load($data);
        $model->userid = $user->id;
        $model->created_at = time();
        //var_dump();
        if ($model->save()) {
            return 	array (
        			'flag' => 1,
        			'msg' => 'create job applying success!'
        	);
        } else {
        	//var_dump($model->errors);
            return 	array (
            		'error'=>$model->errors,
        			'flag' => 0,
        			'msg' => 'create job applying fail!'
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
    	if(!isset($data['phone'])||!isset($data['applyjobid'])){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	$user = Users::findOne(['phone'=>$data['phone']]);
    	$applyjob=$this->findModel($data['applyjobid']);
    	if (!$applyjob||!$user){
    		return  array (
    				'flag' => 0,
    				'msg' => 'update job applying fail!'
    		);
    	}
        //$model = $this->findModel($id);
		unset($data['phone']);
		unset($data['applyjobid']);
		
		foreach ($data as $item=>$arg ){
			$applyjob->$item = $arg;
		}
		
        if ($applyjob->save()) {
            return 	array (
        			'flag' => 1,
        			'msg' => 'update job applying success!'
        	);
        } else {
            return  array (
    				'flag' => 0,
    				'msg' => 'update job applying fail!'
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
    	if(!isset($data['phone'])||!isset($data['applyjobid'])){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	$user = Users::findOne(['phone'=>$data['phone']]);
        $applyjob=$this->findModel($data['applyjobid']);
        if (!$applyjob||!$user){
        	return  array (
						'flag' => 0,
						'msg' => 'delete job applying fail!'
				);
        }
		if ($applyjob->userid == $user->id){
			if($applyjob->delete()){
				return 	array (
						'flag' => 1,
						'msg' => 'delete job applying success!'
				);
			}else{
				return 	array (
						'flag' => 0,
						'msg' => 'delete job applying fail!'
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
        if (($model = Applyjobs::findOne($id)) !== null) {
            return $model;
        }else {
        	return false;
        }
    }
}
