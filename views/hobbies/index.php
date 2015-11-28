<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HobbiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hobbies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hobbies-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Hobbies', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'hobby',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
