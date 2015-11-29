<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GrabcornsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="grabcorns-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            [
        		'attribute' => 'picture',
'label'=>'缩略图',
        		'value'=>'picture',
				'format' => ['image',['width'=>'60','height'=>'60']],
        						],
            'title',
            'version',
            'needed',
             'remain',
            // 'created_at',
             'date',
             'end_at',
             'islotteried',
             'winneruserid',
             'winnerrecordid',
             'winnernumber',
             'foruser',
            // 'kind',
            // 'pictures',
             'worth',
        		'isgot',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
