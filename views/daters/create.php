<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Daters */

$this->title = 'Create Daters';
$this->params['breadcrumbs'][] = ['label' => 'Daters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daters-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
