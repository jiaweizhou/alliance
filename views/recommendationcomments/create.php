<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Recommendationcomments */

$this->title = 'Create Recommendationcomments';
$this->params['breadcrumbs'][] = ['label' => 'Recommendationcomments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommendationcomments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
