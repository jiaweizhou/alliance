<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<style>
    label{display: none;}
    .mr20{margin-right:20px;}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4 sm col-sm-1"></div>
        <div class="col-md-4 sm col-sm-1">
            <h3><p><span class='glyphicon glyphicon-user'></span>&nbsp;欢迎使用数据管理中心</p></h3>
            <?php $form=ActiveForm::begin([
                'id'=>'login',
                'enableAjaxValidation' => false,
                'options'=>['enctype'=>'multipart/form-data']
            ]);?>

            <?=$form->field($model,'name')->textInput(["placeholder"=>"账号"]); ?>
            <?=$form->field($model,'pwd')->passwordInput(['placeholder'=>'密码']); ?>
<!--            --><?//=$form->field($model,'verifyCode')->widget(Captcha::className(),['captchaAction'=>'public/captcha',
//                'template'=>'<div class="row"><div class="col-md-3 col-xs-4 mr20">{image}</div><div class="col-md-6 col-xs-6">{input}</div></div>'
//            ])?>
            <?=  Html::submitButton('登录', ['class'=>'btn btn-primary btn-lg btn-block','name' =>'submit-button']) ?>
            <?php ActiveForm::end();?>
        </div>
        <div class="col-md-4 sm col-sm-1"></div>
    </div>
</div>


