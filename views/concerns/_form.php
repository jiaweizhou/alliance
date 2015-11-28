<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Concerns */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="concerns-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'myid')->textInput() ?>

    <?= $form->field($model, 'concernid')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
