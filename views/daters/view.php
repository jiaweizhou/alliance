<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Daters */

$this->title ='';
$this->params['breadcrumbs'][] = ['label' => 'Daters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="daters-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'userid',
            [
        		'attribute'=>'缩略图',
        				'value'=>$model->picture,
        				'format' => ['image',['width'=>'100','height'=>'100']],
        						],
            'sex',
            'age',
            'hobbyid',
            'content',
            'created_at',
        ],
    ]) ?>

</div>
