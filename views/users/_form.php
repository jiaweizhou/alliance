<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pwd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fatherid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'directalliancecount')->textInput() ?>

    <?= $form->field($model, 'allalliancecount')->textInput() ?>

    <?= $form->field($model, 'corns')->textInput() ?>

    <?= $form->field($model, 'money')->textInput() ?>

    <?= $form->field($model, 'envelope')->textInput() ?>

    <?= $form->field($model, 'cornsforgrab')->textInput() ?>

    <?= $form->field($model, 'alliancerewards')->textInput() ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hobby')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'signature')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'channel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'platform')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'friendcount')->textInput() ?>

    <?= $form->field($model, 'concerncount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
