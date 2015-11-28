<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Kindsofrecommendation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kindsofrecommendation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kind')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
