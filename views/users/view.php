<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Users */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'phone',
            'pwd',
            'authKey',
            'fatherid',
            'directalliancecount',
            'allalliancecount',
            'corns',
            'money',
            'envelope',
            'cornsforgrab',
            'alliancerewards',
            'nickname',
            'thumb',
            'gender',
            'area',
            'job',
            'hobby',
            'signature',
            'created_at',
            'updated_at',
            'channel',
            'platform',
            'friendcount',
            'concerncount',
            'isdraw',
        ],
    ]) ?>

</div>
