<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Tbmessages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbmessages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'pictures')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'likecount')->textInput() ?>

    <?//= $form->field($model, 'replycount')->textInput() ?>

    <?//= $form->field($model, 'created_at')->textInput() ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
