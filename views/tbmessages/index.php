<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TbmessagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbmessages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbmessages-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbmessages', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'userid',
            'content',
            'pictures',
            'likecount',
            // 'replycount',
            // 'created_at',
            // 'title',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
