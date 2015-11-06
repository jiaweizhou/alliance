<?php

namespace app\modules\v1\controllers;

use Yii;
use app\modules\v1\models\Professions;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfessionsController implements the CRUD actions for Professions model.
 */
class ProfessionsController extends Controller
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
        $dataProvider = new ActiveDataProvider([
            'query' => Professions::find(),
        ]);

        return $dataProvider;
    }

    /**
     * Displays a single Professions model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return  Professions::findone($id);
    }

    /**
     * Creates a new Professions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Professions();
        $data = Yii::$app->request->post();
        $model->profession = isset($data['profession'])?$data['profession']:'';
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        if (($model = Professions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
