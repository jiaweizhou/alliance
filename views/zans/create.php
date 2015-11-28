<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Zans */

$this->title = 'Create Zans';
$this->params['breadcrumbs'][] = ['label' => 'Zans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zans-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
