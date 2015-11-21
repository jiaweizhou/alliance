<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Recommendations;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\v1\models\Users;

/**
 * ApplyjobsController implements the CRUD actions for Applyjobs model.
 */
class RecommendationsController extends Controller
{
	public $modelClass = 'app\modules\v1\models\Recommendations';
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
		$query = (new \yii\db\Query ())->select('recommendations.*,users.phone,users.nickname,users.thumb,kindsofrecommendation.kind')->from('recommendations')->join('INNER JOIN','users','recommendations.userid = users.id')->join('INNER JOIN','kindsofrecommendation','recommendations.kindid = kindsofrecommendation.id');
// 		$dataProvider = new ActiveDataProvider([
// 				'query' => $query,
// 		]);
		
		if(!empty($data)){
			if(isset($data['phone'])){
					$query->andFilterWhere(['users.phone' => $data['phone']]);
			}
			
			if(isset($data['kindid'])){
				$query->andFilterWhere(['kindid' => $data['kindid']]);
			}
			if(isset($data['title'])){
				$query->andFilterWhere(['like', 'title',$data['title']]);
			}
		}
		$dataProvider = new \yii\data\Pagination ( [
				'totalCount' => $query->count (),
				'pageSize' => '20'
				] );
		$models = $query->orderBy ( "recommendations.created_at desc" )->offset ( $dataProvider->offset )->limit ( $dataProvider->limit )->all ();
		//var_dump($models);
		$result['items'] =array();
		foreach ( $models as $model ) {
			$comments = (new \yii\db\Query ())->select ( [
					'recommendationcomments.*',
					'users.phone',
					'users.nickname',
					'users.thumb'
					] )->from ( 'recommendationcomments' )->join ( 'INNER JOIN', 'users', 'recommendationcomments.userid = users.id and recommendationcomments.recommendationid = :id', [
						':id' => $model ['id']
					] )->all ();
			$model['comments'] = $comments;
			$result['items'][]=$model;
		}
		//$result['items'] = $models;
		$result['_meta'] = array(
			'totalCount'=>$dataProvider->totalCount,
			'pageCount'=>$dataProvider->pageCount,
			'currentPage'=>$dataProvider->page+1,
			'perPage'=>$dataProvider->pageSize,
		);
		//$dataProvider->on($name, $handler)
		//$dataProvider->
		return $result;
	}

    /**
     * Creates a new Applyjobs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	
        $model = new Recommendations();
        $data=Yii::$app->request->post();
        
        if(empty($data['phone'])||empty($data['title'])||empty($data['location'])||empty($data['kindid'])||empty($data['reason'])){
        	return 	array (
        			'flag' => 0,
        			'msg' => 'no enough arg!'
        	);
        }
        
        $user = Users::findOne(['phone'=>$data['phone']]);
        if(!$user){
        	return 	array (
        			'flag' => 0,
        			'msg' => 'create recommendation fail!'
        	);
        }
        unset($data['phone']);
        $model->title = isset($data['title'])?$data['title']:'';
        $model->kindid = $data['kindid'];
        $model->location = $data['location'];
        $model->sellerphone = isset($data['sellerphone'])?$data['sellerphone']:'';
        $model->reason = $data['reason'];
        $model->pictures = isset($data['pictures'])?$data['pictures']:'';
        $model->longitude = isset($data['longitude'])?$data['longitude']:0;
        $model->latitude = isset($data['latitude'])?$data['latitude']:0;
//         $i=0;
//         for($i=1;$i<=9;$i++){
//         	$model->setAttribute('picture'. $i, isset($data['picture' . $i])?$data['picture' . $i]:'');
//         }
//         if(is_array($data['picture'])){
//         	foreach ($data['picture'] as $i=>$picture){
//         		$model->setAttribute('picture'. ($i+1), $picture);
//         	}
//         }
//         for($i++;$i<9;$i++){
//         	$model->setAttribute('picture'. ($i+1), '');
//         }
        //$model->load($data);
        $model->userid = $user->id;
        $model->created_at = time();
        //var_dump();
        if ($model->save()) {
            return 	array (
        			'flag' => 1,
        			'msg' => 'create recommendation success!'
        	);
        } else {
        	//var_dump($model->errors);
            return 	array (
        			'flag' => 0,
        			'msg' => 'create recommendation fail!'
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
			$recommendation->$item = $arg;
		}
		
        if ($recommendation->save()) {
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
