<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Tbreplys */

$this->title = 'Create Tbreplys';
$this->params['breadcrumbs'][] = ['label' => 'Tbreplys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbreplys-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
