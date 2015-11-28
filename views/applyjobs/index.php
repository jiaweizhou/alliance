<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApplyjobsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applyjobs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applyjobs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Applyjobs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'userid',
            'jobproperty',
            'title',
            'degree',
            // 'work_at',
            // 'status',
            // 'hidephone',
            // 'content',
            // 'professionid',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
