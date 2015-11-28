<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Kindsofrecommendation */

$this->title = 'Create Kindsofrecommendation';
$this->params['breadcrumbs'][] = ['label' => 'Kindsofrecommendations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kindsofrecommendation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
