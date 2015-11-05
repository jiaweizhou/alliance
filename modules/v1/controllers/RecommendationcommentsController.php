<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Recommendationcomments;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\Users;

/**
 * ApplyjobsController implements the CRUD actions for Applyjobs model.
 */
class RecommendationcommentsController extends Controller
{
	public $modelClass = 'app\modules\v1\models\Recommendationcomments';
	public $serializer = [
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items'
	];
  

    public function actionCreate()
    {
    	
        $model = new Recommendationcomments();
        $data=Yii::$app->request->post();
        
        if(empty($data['phone'])||empty($data['recommendationid'])||empty($data['content'])){
        	return 	array (
        			'flag' => 0,
        			'msg' => 'no enough arg!'
        	);
        }
        
        $user = Users::findOne(['phone'=>$data['phone']]);
        if(!$user){
        	return 	array (
        			'flag' => 0,
        			'msg' => 'create recommendationcomment fail!'
        	);
        }
        unset($data['phone']);
        //$model->recommendationid = isset($data['title'])?$data['title']:'';
        $model->recommendationid = $data['recommendationid'];
        $model->content = $data['content'];
        $model->userid = $user->id;
        $model->created_at = time();
        //var_dump();
        if ($model->save()) {
            return 	array (
        			'flag' => 1,
        			'msg' => 'create recommendationcomment success!'
        	);
        } else {
        	//var_dump($model->errors);
            return 	array (
        			'flag' => 0,
        			'msg' => 'create recommendationcomment fail!'
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
    	if(!isset($data['phone'])||!isset($data['recommendationid'])){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	$user = Users::findOne(['phone'=>$data['phone']]);
    	$recommendation=$this->findModel($data['recommendationid']);
    	if (!$recommendation||!$user){
    		return  array (
    				'flag' => 0,
    				'msg' => 'update job applying fail!'
    		);
    	}
    	if ($recommendation->userid != $user->id){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'have no authority!'
    		);
    	}
        //$model = $this->findModel($id);
		unset($data['phone']);
		unset($data['recommendationid']);
		
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
    	if(!isset($data['phone'])||!isset($data['recommendationid'])){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	$user = Users::findOne(['phone'=>$data['phone']]);
        $recommendation=$this->findModel($data['recommendationid']);
        if (!$recommendation||!$user){
        	return  array (
						'flag' => 0,
						'msg' => 'delete job applying fail!'
				);
        }
		if ($recommendation->userid == $user->id){
			if($recommendation->delete()){
				return 	array (
						'flag' => 1,
						'msg' => 'delete recommendation success!'
				);
			}else{
				return 	array (
						'flag' => 0,
						'msg' => 'delete recommendation fail!'
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
        if (($model = Recommendations::findOne($id)) !== null) {
            return $model;
        }else {
        	return false;
        }
    }
}
