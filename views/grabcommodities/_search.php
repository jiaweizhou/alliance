<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GrabcommoditiesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grabcommodities-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'picture') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'version') ?>

    <?= $form->field($model, 'needed') ?>

    <?php // echo $form->field($model, 'remain') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'end_at') ?>

    <?php // echo $form->field($model, 'islotteried') ?>

    <?php // echo $form->field($model, 'winneruserid') ?>

    <?php // echo $form->field($model, 'winnerrecordid') ?>

    <?php // echo $form->field($model, 'winnernumber') ?>

    <?php // echo $form->field($model, 'foruser') ?>

    <?php // echo $form->field($model, 'kind') ?>

    <?php // echo $form->field($model, 'pictures') ?>

    <?php // echo $form->field($model, 'details') ?>

    <?php // echo $form->field($model, 'worth') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
