<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TbreplysSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbreplys-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tbmessageid') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'fromid') ?>

    <?= $form->field($model, 'toid') ?>

    <?php // echo $form->field($model, 'isread') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
