<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ApplyjobsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="applyjobs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'jobproperty') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'degree') ?>

    <?php // echo $form->field($model, 'work_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'hidephone') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'professionid') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
