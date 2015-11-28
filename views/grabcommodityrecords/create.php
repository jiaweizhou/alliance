<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Grabcommodityrecords */

$this->title = 'Create Grabcommodityrecords';
$this->params['breadcrumbs'][] = ['label' => 'Grabcommodityrecords', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grabcommodityrecords-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
