<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
        	   'nickname',
            'phone',
        		[
    		'attribute' => 'thumb',
'label'=>'头像',
		'value'=>'thumb',
				'format' => ['image',['width'=>'40','height'=>'40']],
						],
           // 'pwd',
            //'authKey',
            'fatherid',
             'directalliancecount',
             'allalliancecount',
             'corns',
             'money',
            // 'envelope',
             'cornsforgrab',
             'alliancerewards',
            // 'gender',
            // 'area',
            // 'job',
            // 'hobby',
            // 'signature',
            // 'created_at',
            // 'updated_at',
            // 'channel',
            // 'platform',
            // 'friendcount',
            // 'concerncount',
            // 'isdraw',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
