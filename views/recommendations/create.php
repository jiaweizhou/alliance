<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Recommendations */

$this->title = 'Create Recommendations';
$this->params['breadcrumbs'][] = ['label' => 'Recommendations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommendations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
