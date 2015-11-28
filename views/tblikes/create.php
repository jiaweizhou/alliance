<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Tblikes */

$this->title = 'Create Tblikes';
$this->params['breadcrumbs'][] = ['label' => 'Tblikes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblikes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
