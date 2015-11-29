<?php
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
?>
<!DOCTYPE HTML>
<html>
<html lang="en-US" style="padding-left:-15px">
<head>
    <title>管理系统</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?=Html::cssFile('@web/assets/css/dpl-min.css')?>
    <?=Html::cssFile('@web/assets/css/bui-min.css')?>
    <?=Html::cssFile('@web/assets/css/main-min.css')?>
    <?=Html::cssFile('@web/css/site.css')?>
    <?=Html::jsFile('@web/assets/js/jquery-1.8.1.min.js')?>
    <?=Html::jsFile('@web/assets/js/bui-min.js')?>
    <?=Html::jsFile('@web/assets/js/common/main-min.js')?>
    <?=Html::jsFile('@web/assets/js/config-min.js')?>
   

</head>
<body>


<div class="header">

    <div class="dl-title">
        <!--<img src="/chinapost/Public/assets/img/top.png">-->
    </div>

    <div class="dl-log">欢迎您！ <a href="<?=Yii::$app->urlManager->createUrl(['admin/login'])?>" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
</div>
<div class="content">
    <div class="dl-main-nav">
        <div class="dl-inform"><div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div></div>
        <ul id="J_Nav"  class="nav-list ks-clear">
            <li class="nav-item dl-selected"><div class="nav-item-inner nav-home">自己人联盟系统管理</div></li>		

        </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
</div>


<script>
    var myapp="<?= Yii::$app->urlManager->createUrl('admin/system')?>";
    var users="<?= Yii::$app->urlManager->createUrl('users/index')?>";
    var usertocards="<?= Yii::$app->urlManager->createUrl('usertocards/index')?>";
    var friends="<?= Yii::$app->urlManager->createUrl('friends/index')?>";
    var grabcommodities="<?= Yii::$app->urlManager->createUrl('grabcommodities/index')?>";
    var grabcommodityrecords="<?= Yii::$app->urlManager->createUrl('grabcommodityrecords/index')?>";
    var grabcorns="<?= Yii::$app->urlManager->createUrl('grabcorns/index')?>";
    var grabcornrecords="<?= Yii::$app->urlManager->createUrl('grabcornrecords/index')?>";
    var messages="<?= Yii::$app->urlManager->createUrl('messages/index')?>";
    var replys="<?= Yii::$app->urlManager->createUrl('replys/index')?>";
    var tbmessages="<?= Yii::$app->urlManager->createUrl('tbmessages/index')?>";
    var tbreplys="<?= Yii::$app->urlManager->createUrl('tbreplys/index')?>";
    var concerns="<?= Yii::$app->urlManager->createUrl('concerns/index')?>";
    var applyjobs="<?= Yii::$app->urlManager->createUrl('applyjobs/index')?>";
    var professions="<?= Yii::$app->urlManager->createUrl('professions/index')?>";
    var recommendations="<?= Yii::$app->urlManager->createUrl('recommendations/index')?>";
    var kindsofrecommendation="<?= Yii::$app->urlManager->createUrl('kindsofrecommendation/index')?>";
var recommendationcomments="<?= Yii::$app->urlManager->createUrl('recommendationcomments/index')?>";
   var  daters="<?= Yii::$app->urlManager->createUrl('daters/index')?>";
   var  hobbies="<?= Yii::$app->urlManager->createUrl('hobbies/index')?>";


    BUI.use('common/main',function(){
        var config = [
            {id:'1',menu:[
 				  {text:'用户管理',items:[{id:'11',text:'用户',href:users},{id:'12',text:'用户银行卡',href:usertocards},
				    				  {id:'13',text:'好友关系',href:friends}]},

				  {text:'夺宝夺金管理',items:[{id:'22',text:'夺宝',href:grabcommodities},{id:'23',text:'夺宝记录',href:grabcommodityrecords},{id:'24',text:'夺金',href:grabcorns},
                       {id:'25',text:'夺金记录',href:grabcornrecords}]},

                    {text:'朋友圈管理',items:[{id:'33',text:'消息',href:messages},{id:'34',text:'消息回复',href:replys}]},

                    {text:'聊吧管理',items:[{id:'44',text:'消息',href:tbmessages},{id:'45',text:'消息回复',href:tbreplys},{id:'46',text:'关注关系',href:concerns}]},

                    {text:'求职管理',items:[{id:'55',text:'求职帖子',href:applyjobs},{id:'56',text:'职业类型',href:professions}]},

                    {text:'推荐管理',items:[{id:'66',text:'推荐帖子',href:recommendations},{id:'67',text:'推荐类型',href:kindsofrecommendation},{id:'68',text:'评论',href:recommendationcomments}]},

                   {text:'交友管理',items:[{id:'77',text:'交友贴子',href:daters},{id:'78',text:'个人爱好',href:hobbies}]},
                ]},
            {id:'7',homePage : '9',menu:[{text:'业务管理',items:[{id:'9',text:'查询业务',href:myapp}]}]}
        ];
        new PageUtil.MainPage({
            modulesConfig : config
        });
    });
</script>
</body>
</html>
