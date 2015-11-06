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
		$query = (new \yii\db\Query ())->select('applyjobs.*,users.phone,users.nickname,users.thumb,professions.profession')->from('applyjobs')->orderBy('created_at desc')->join('INNER JOIN','users','applyjobs.userid = users.id')->join('INNER JOIN','professions','applyjobs.professionid = professions.id');
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
		return $dataProvider;
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
