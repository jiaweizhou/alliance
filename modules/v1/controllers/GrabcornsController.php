<?php

namespace app\modules\v1\controllers;

use Yii;
use Exception;
use app\modules\v1\models\Grabcorns;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\Users;
use app\modules\v1\models\app\modules\v1\models;

/**
 * ApplyjobsController implements the CRUD actions for Applyjobs model.
 */
class GrabcornsController extends Controller
{
	public $modelClass = 'app\modules\v1\models\Grabcorns';
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
// 		$data=Yii::$app->request->post();
// 		$query = (new \yii\db\Query ())->select('daters.*,users.phone,users.nickname,users.thumb,hobbies.hobby')->from('daters')->orderBy('created_at desc')->join('INNER JOIN','users','daters.userid = users.id')->join('INNER JOIN','hobbies','daters.hobbyid = hobbies.id');
// 		$dataProvider = new ActiveDataProvider([
// 				'query' => $query,
// 		]);
// 		//$this->load($params);
// 		//$value = 0;
// 		if(!empty($data)){
// 			if(isset($data['phone'])){
// 					$query->andFilterWhere(['users.phone' => $data['phone']]);
// 			}
			
// 			if(isset($data['hobbyid'])){
// 				$query->andFilterWhere(['hobbyid' => $data['hobbyid']]);
// 			}
// 			if(isset($data['content'])){
// 				$query->andFilterWhere(['like', 'content',$data['content']]);
// 			}
// 		}	
		//$query = (new \yii\db\Query ())->select('daters.*,users.phone,users.nickname,users.thumb,hobbies.hobby')->from('daters')->orderBy('created_at desc')->join('INNER JOIN','users','daters.userid = users.id')->join('INNER JOIN','hobbies','daters.hobbyid = hobbies.id');
		$query = Grabcorns::find()->orderBy('created_at desc')->where(['islotteried'=>0]);
		$dataProvider = new ActiveDataProvider([
						'query' => $query,
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
    	
        $model = new Grabcorns();
        $data=Yii::$app->request->post();
        //var_dump(isset($date['content']);
        if(!(isset($data['picture'])&&isset($data['title'])&&isset($data['version'])&&isset($data['needed'])&&isset($data['date'])&&isset($data['end_at']))){
        	return 	array (
        			'flag' => 0,
        			'msg' => 'no enough arg!'
        	);
        }
        
        $data['created_at'] = time();
        $data['remain'] = $data['needed'];
        foreach ($data as $item=>$value){
        	$model->$item = $data[$item];
        }
        if ($model->save()) {
            return 	array (
        			'flag' => 1,
        			'msg' => 'create grabcorn success!'
        	);
        } else {
        	//var_dump($model->errors);
            return 	array (
        			'flag' => 0,
        			'msg' => 'create grabcorn fail!'
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
    	if(!isset($data['grabcornid'])){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	$grabcorn=$this->findModel($data['grabcornid']);
    	if (!$dater){
    		return  array (
    				'flag' => 0,
    				'msg' => 'update dater fail!'
    		);
    	}
        //$model = $this->findModel($id);
		//unset($data['phone']);
		unset($data['grabcornid']);
		
		foreach ($data as $item=>$arg ){
			$grabcorn->$item = $arg;
		}
		
        if ($grabcorn->save()) {
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
    	if(!isset($data['grabcornid'])){
    		return 	array (
    				'flag' => 0,
    				'msg' => 'no enough arg!'
    		);
    	}
    	
        $grabcorn=$this->findModel($data['grabcornid']);
        if (!$grabcorn){
        	return  array (
						'flag' => 0,
						'msg' => 'delete grabcorn fail!'
				);
        }
		if($grabcorn->delete()){
			return 	array (
					'flag' => 1,
					'msg' => 'delete grabcorn success!'
			);
		}else{
			return 	array (
					'flag' => 0,
					'msg' => 'delete grabcorn fail!'
			);
		}
    }

    
    public function actionBuy(){
    	$data=Yii::$app->request->post();
    	if(!(isset($data['phone'])&&isset($data['grabcornid'])&&isset($data['count'])&&isset($data['type']))){
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
    	
    	$updatecount = 0;
    	$inserrecord = 0;
    	$updatemoney = 0;
    	for ($i = 0; $i < $data['count']; $i++) {
    		
    	}
    	$connection = Yii::$app->db;
    	$transaction=$connection->beginTransaction();
    	try {
    		
    		$connection->createCommand('select * from grabcorns where id=:id for update',[':id'=>$data['grabcornid'],':count'=>$data['count']]);
    		$connection->createCommand('select * from users where id=:id for update',[':id'=>$data['grabcornid'],':count'=>$data['count']]);
    		$updatecount=$connection->createCommand('update grabcorns set remain=remain-:count where id=:id and remain>=:count',[':id'=>$data['grabcornid'],':count'=>(int)$data['count']])->execute();
    		switch ($data['type']){
    			case 0://yuer
    				$updatemoney=$connection->createCommand('update users set money = money-:count where id = :userid and money>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 1://duojinbi
    				$updatemoney=$connection->createCommand('update users set cornsforgrab = cornsforgrab-:count where id = :userid and cornsforgrab>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 2://hongbao
    				$updatemoney=$connection->createCommand('update users set envelope = envelope-:count where id = :userid and envelope>=:count',[':userid'=>$user->id,':count'=>$data['count']])->execute();
    				break;
    			case 3://jinbi
    				break;
    			case 4://zhifupintai
    				break;
    		}
    		//$updatemoney=$connection->createCommand('update users set ')->execute();
    		$inserrecord=$connection->createCommand('insert into grabcornrecords(userid,grabcornid,count,numbers,created_at) values (:userid,:grabcornid,:count,:numbers,:created_at)'
    					,[':userid'=>$user->id,':grabcornid'=>$data['grabcornid'],':count'=>$data['count'],':numbers'=>"",':created_at'=>time()])->execute();
    		//var_dump($expression)
    		if(!(($data['type']==3||$data['type']==4||$updatemoney)&&$updatecount&&$inserrecord)){
    			throw new Exception("Value must be 1 or below");
    		}
    		// ... executing other SQL statements ...
    		$transaction->commit();
    	} catch (Exception $e) {
    		$transaction->rollBack();
    		var_dump("133435465");
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
        if (($model = Grabcorns::findOne($id)) !== null) {
            return $model;
        }else {
        	return false;
        }
    }
}
