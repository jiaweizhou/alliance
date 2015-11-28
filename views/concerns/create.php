<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Concerns */

$this->title = 'Create Concerns';
$this->params['breadcrumbs'][] = ['label' => 'Concerns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="concerns-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
