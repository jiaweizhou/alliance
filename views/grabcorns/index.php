<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GrabcornsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grabcorns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grabcorns-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Grabcorns', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'picture',
            'title',
            'version',
            'needed',
            // 'remain',
            // 'created_at',
            // 'date',
            // 'end_at',
            // 'islotteried',
            // 'winneruserid',
            // 'winnerrecordid',
            // 'winnernumber',
            // 'foruser',
            // 'kind',
            // 'pictures',
            // 'worth',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
