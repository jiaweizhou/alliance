<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'pwd') ?>

    <?= $form->field($model, 'authKey') ?>

    <?= $form->field($model, 'fatherid') ?>

    <?php // echo $form->field($model, 'directalliancecount') ?>

    <?php // echo $form->field($model, 'allalliancecount') ?>

    <?php // echo $form->field($model, 'corns') ?>

    <?php // echo $form->field($model, 'money') ?>

    <?php // echo $form->field($model, 'envelope') ?>

    <?php // echo $form->field($model, 'cornsforgrab') ?>

    <?php // echo $form->field($model, 'alliancerewards') ?>

    <?php // echo $form->field($model, 'nickname') ?>

    <?php // echo $form->field($model, 'thumb') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'job') ?>

    <?php // echo $form->field($model, 'hobby') ?>

    <?php // echo $form->field($model, 'signature') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'channel') ?>

    <?php // echo $form->field($model, 'platform') ?>

    <?php // echo $form->field($model, 'friendcount') ?>

    <?php // echo $form->field($model, 'concerncount') ?>

    <?php // echo $form->field($model, 'isdraw') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
