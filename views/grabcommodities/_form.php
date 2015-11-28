<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Grabcommodities */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grabcommodities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'picture')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'needed')->textInput() ?>

    <?= $form->field($model, 'remain')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'end_at')->textInput() ?>

    <?= $form->field($model, 'islotteried')->textInput() ?>

    <?= $form->field($model, 'winneruserid')->textInput() ?>

    <?= $form->field($model, 'winnerrecordid')->textInput() ?>

    <?= $form->field($model, 'winnernumber')->textInput() ?>

    <?= $form->field($model, 'foruser')->textInput() ?>

    <?= $form->field($model, 'kind')->textInput() ?>

    <?= $form->field($model, 'pictures')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'details')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
