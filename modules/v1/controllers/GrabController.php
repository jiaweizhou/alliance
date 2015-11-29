<?php

namespace app\modules\v1\controllers;

use Yii;
use Exception;
use app\modules\v1\models\Grabcorns;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
// require dirname ( __FILE__ ) . '/Cachelock.php';
// use CacheLock;
use app\modules\v1\controllers\CacheLock;
use yii\filters\VerbFilter;
use app\modules\v1\models\Users;
use app\modules\v1\models\app\modules\v1\models;

/**
 * ApplyjobsController implements the CRUD actions for Applyjobs model.
 */
class GrabController extends Controller
{
	public $modelClass = 'app\modules\v1\models\Grabcorns';
	public $serializer = [
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items'
	];
  
    /**
     * Lists all Applyjobs models.
     * @return mixed
     *///ji jiang kai jiang
	public function actionList()
	{ 
// 		$data=Yii::$app->request->post();
		//$query = Grabcorns::find()->where(['islotteried'=>0]);

		$data=Yii::$app->request->post();
		$query = (new \yii\db\Query ())->orderBy('date desc')->select('grabcorns.id,1 as noty,picture,needed,remain,')->from('grabcorns');
				$dataProvider = new ActiveDataProvider([
						'query' => $query,
				]);
		//var_dump(isset($data['type']));
		
		$query->where('grabcorns.islotteried = 0 and end_at != 0 and foruser = 0');
		
		return $dataProvider;	
	}

	public function actionWin(){
		$data=Yii::$app->request->post();
		if(!isset($data['phone'])){
			return 	array (
					'flag' => 0,
					'msg' => 'no enough arg!'
			);
		}
		//(new \yii\db\Query ())->createCommand();
		
		$query = (new \yii\db\Query ())
		->select(['if(isnull(grabcornrecords.id),0,0) as tbk','grabcorns.id as flag','grabcornrecords.id','grabcornrecords.grabcornid as grabid','grabcornrecords.userid','grabcornrecords.type','grabcornrecords.created_at','grabcornrecords.isgotback','grabcorns.isgot','grabcorns.picture','grabcorns.title','grabcorns.version','grabcorns.date','grabcorns.needed','grabcorns.end_at','grabcorns.islotteried','grabcorns.winnernumber','users.nickname','users.phone','users.thumb'])
		->from('grabcornrecords')
		->join('INNER JOIN','grabcorns','grabcornrecords.grabcornid = grabcorns.id')
		->join('INNER JOIN','users','grabcornrecords.userid = users.id and winnerrecordid = grabcornrecords.id')
		->union(
				(new \yii\db\Query ())
				->select(['if(isnull(grabcommodityrecords.id),1,1) as tbk','grabcommodityrecords.id as flag','grabcommodityrecords.id','grabcommodityrecords.grabcommodityid as grabid','grabcommodityrecords.userid','grabcommodityrecords.type','grabcommodityrecords.created_at','grabcommodityrecords.isgotback','grabcommodities.isgot','grabcommodities.picture','grabcommodities.title','grabcommodities.version','grabcommodities.date','grabcommodities.needed','grabcommodities.end_at','grabcommodities.islotteried','grabcommodities.winnernumber','users.nickname','users.phone','users.thumb'])
				->from('grabcommodityrecords')
				->join('INNER JOIN','grabcommodities','grabcommodityrecords.grabcommodityid = grabcommodities.id and winnerrecordid = grabcommodityrecords.id')
				->join('INNER JOIN','users','grabcommodityrecords.userid = users.id'),
				true
		)
		->orderBy('created_at des');
		//var_dump($query);
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
		}
		return $dataProvider;
		
		
	}

    /**
     * Creates a new Applyjobs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    

    


}
