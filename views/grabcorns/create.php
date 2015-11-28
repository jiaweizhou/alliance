<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Grabcorns */

$this->title = 'Create Grabcorns';
$this->params['breadcrumbs'][] = ['label' => 'Grabcorns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grabcorns-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
