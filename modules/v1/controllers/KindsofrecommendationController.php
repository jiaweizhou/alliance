<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Kindsofrecommendation;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfessionsController implements the CRUD actions for Professions model.
 */
class KindsofrecommendationController extends Controller
{
    /**
     * Lists all Professions models.
     * @return mixed
     */
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'items'
	];
    public function actionList()
    {
//         $dataProvider = new ActiveDataProvider([
//             'query' => Kindsofrecommendation::find(),
//         ]);

//         return $dataProvider;
    	return Kindsofrecommendation::find()->all();
    }

    /**
     * Creates a new Professions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kindsofrecommendation();
        $data = Yii::$app->request->post();
        $model->kind = isset($data['kind'])?$data['kind']:'';
        if ($model->save()) {
	    	return array(
	            'flag' => 1,
	            'msg' => 'create success!'
	        	);
        }else{
            return array(
            	'flag' => 0,
            	'msg' => 'create fail!'
            );
       	}

    }

    /**
     * Updates an existing Professions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Professions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
    	$data = Yii::$app->request->post();

    	if ($this->findModel($data['id'])->delete()) {
	    	return array(
	            'flag' => 1,
	            'msg' => 'delete success!'
	        	);
        }else{
            return array(
            	'flag' => 0,
            	'msg' => 'delete fail!'
            );
       	}
    }

    /**
     * Finds the Professions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Professions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kindsofrecommendation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
