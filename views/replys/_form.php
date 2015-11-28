<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Replys */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="replys-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'messageid')->textInput() ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fromid')->textInput() ?>

    <?= $form->field($model, 'toid')->textInput() ?>

    <?= $form->field($model, 'isread')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
