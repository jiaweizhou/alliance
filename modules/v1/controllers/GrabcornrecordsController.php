<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Grabcornrecords;
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
class GrabcornrecordsController extends Controller
{
	public $modelClass = 'app\modules\v1\models\Grabcornrecords';
	public $serializer = [
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items'
	];
  
    /**
     * Lists all Applyjobs models.
     * @return mixed
     */

	public function actionList()
	{ 
		$data=Yii::$app->request->post();
		
		
		$query = (new \yii\db\Query ())
		->select('grabcornrecords.*,grabcorns.picture,grabcorns.title,grabcorns.id as version,grabcorns.date,grabcorns.needed,grabcorns.end_at,grabcorns.islotteried,grabcorns.winnernumber,g2.count as winnercount,users.nickname,users.phone,users.thumb')
		->from('grabcornrecords')
		->orderBy('grabcornrecords.created_at desc')
		->join('INNER JOIN','grabcorns','grabcornrecords.grabcornid = grabcorns.id')
		->join('LEFT JOIN','grabcornrecords g2','grabcorns.winnerrecordid = g2.id')
		->join('LEFT JOIN','users','g2.userid = users.id');
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
		]);
		//$this->load($params);
		//$value = 0;
		if(!empty($data)){
			if(isset($data['phone'])){
				$user = Users::findOne(['phone'=>$data['phone']]);
				$query->andFilterWhere(['grabcornrecords.userid' => $user->id]);
			}
			
// 			if(isset($data['hobbyid'])){
// 				$query->andFilterWhere(['hobbyid' => $data['hobbyid']]);
// 			}
// 			if(isset($data['content'])){
// 				$query->andFilterWhere(['like', 'content',$data['content']]);
// 			}
		}	
		return $dataProvider;
	}
	
	
	
	public function actionWin()
	{
		$data=Yii::$app->request->post();
		$query = (new \yii\db\Query ())
		->select('grabcorns.id as flag, grabcornrecords.*,grabcorns.isgot,grabcorns.picture,grabcorns.title,grabcorns.id as version,grabcorns.date,grabcorns.needed,grabcorns.end_at,grabcorns.islotteried,grabcorns.winnernumber,users.nickname,users.phone,users.thumb')
		->from('grabcornrecords')
		->orderBy('grabcornrecords.created_at desc')
		->join('INNER JOIN','grabcorns','grabcornrecords.grabcornid = grabcorns.id')
		->join('INNER JOIN','users','grabcornrecords.userid = users.id and winnerrecordid = grabcornrecords.id');
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
		]);
		//$this->load($params);
		//$value = 0;
		if(!empty($data)){
			if(isset($data['phone'])){
				$user = Users::findOne(['phone'=>$data['phone']]);
				$query->andFilterWhere(['grabcornrecords.userid' => $user->id]);
			}
				
			// 			if(isset($data['hobbyid'])){
			// 				$query->andFilterWhere(['hobbyid' => $data['hobbyid']]);
			// 			}
			// 			if(isset($data['content'])){
			// 				$query->andFilterWhere(['like', 'content',$data['content']]);
			// 			}
			}
			return $dataProvider;
		}
    /**
     * Creates a new Applyjobs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//     public function actionCreate()
//     {
    	
//         $model = new Daters();
//         $data=Yii::$app->request->post();
//         //var_dump(isset($date['content']);
//         if(!(isset($data['phone'])&&isset($data['picture'])&&isset($data['sex'])&&isset($data['age'])&&isset($data['hobbyid'])&&isset($data['content']))){
//         	return 	array (
//         			'flag' => 0,
//         			'msg' => 'no enough arg!'
//         	);
//         }
        
//         $user = Users::findOne(['phone'=>$data['phone']]);
//         if(!$user){
//         	return 	array (
//         			'flag' => 0,
//         			'msg' => 'create dater fail!'
//         	);
//         }
//         $data['userid'] = $user->id;
//         $data['created_at'] = time();
//         foreach ($model->activeAttributes() as $item){
//         	$model->$item = $data[$item];
//         }
//         if ($model->save()) {
//             return 	array (
//         			'flag' => 1,
//         			'msg' => 'create dater success!'
//         	);
//         } else {
//         	//var_dump($model->errors);
//             return 	array (
//         			'flag' => 0,
//         			'msg' => 'create dater fail!'
//         	);
//         }
//     }

//     /**
//      * Updates an existing Applyjobs model.
//      * If update is successful, the browser will be redirected to the 'view' page.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionUpdate()
//     {
//     	$data=Yii::$app->request->post();
//     	if(!isset($data['phone'])||!isset($data['daterid'])){
//     		return 	array (
//     				'flag' => 0,
//     				'msg' => 'no enough arg!'
//     		);
//     	}
//     	$user = Users::findOne(['phone'=>$data['phone']]);
//     	$dater=$this->findModel($data['daterid']);
//     	if (!$dater||!$user){
//     		return  array (
//     				'flag' => 0,
//     				'msg' => 'update dater fail!'
//     		);
//     	}
//     	if ($dater->userid != $user->id){
//     		return 	array (
//     				'flag' => 0,
//     				'msg' => 'have no authority!'
//     		);
//     	}
//         //$model = $this->findModel($id);
// 		unset($data['phone']);
// 		unset($data['daterid']);
		
// 		foreach ($data as $item=>$arg ){
// 			$dater->$item = $arg;
// 		}
		
//         if ($dater->save()) {
//             return 	array (
//         			'flag' => 1,
//         			'msg' => 'update dater success!'
//         	);
//         } else {
//             return  array (
//     				'flag' => 0,
//     				'msg' => 'update dater fail!'
//     		);
//         }
//     }

//     /**
//      * Deletes an existing Applyjobs model.
//      * If deletion is successful, the browser will be redirected to the 'index' page.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionDelete()
//     {
//     	$data=Yii::$app->request->post();
//     	if(!isset($data['phone'])||!isset($data['daterid'])){
//     		return 	array (
//     				'flag' => 0,
//     				'msg' => 'no enough arg!'
//     		);
//     	}
//     	$user = Users::findOne(['phone'=>$data['phone']]);
//         $dater=$this->findModel($data['daterid']);
//         if (!$dater||!$user){
//         	return  array (
// 						'flag' => 0,
// 						'msg' => 'delete dater fail!'
// 				);
//         }
// 		if ($dater->userid == $user->id){
// 			if($dater->delete()){
// 				return 	array (
// 						'flag' => 1,
// 						'msg' => 'delete dater success!'
// 				);
// 			}else{
// 				return 	array (
// 						'flag' => 0,
// 						'msg' => 'delete dater fail!'
// 				);
// 			}
// 		}else{
// 			return 	array (
// 					'flag' => 0,
// 					'msg' => 'have no authority!'
// 			);
// 		}
//     }

//     /**
//      * Finds the Applyjobs model based on its primary key value.
//      * If the model is not found, a 404 HTTP exception will be thrown.
//      * @param integer $id
//      * @return Applyjobs the loaded model
//      * @throws NotFoundHttpException if the model cannot be found
//      */
//     protected function findModel($id)
//     {
//         if (($model = Daters::findOne($id)) !== null) {
//             return $model;
//         }else {
//         	return false;
//         }
//     }
}
