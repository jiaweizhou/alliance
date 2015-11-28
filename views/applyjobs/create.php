<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Applyjobs */

$this->title = 'Create Applyjobs';
$this->params['breadcrumbs'][] = ['label' => 'Applyjobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applyjobs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
