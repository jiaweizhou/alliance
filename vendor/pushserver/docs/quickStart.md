#快速入门

##Step 1 注册成为百度开发者

** !! 如已有开发者帐号,请直接跳至[ Step 2 创建应用并开通push服务 ]**

关于注册开发者帐号, 请参见: [注册成为百度开发者](http://push.baidu.com/docs/register/ '注册成为百度开发者')

##Step 2 创建应用并开通push服务

** !! 如已使用过push服务,请直接跳至[ Step 4 开发环境搭建 ]**

* 关于开通Push服务, 请参见: [创建应用并开通push服务](http://push.baidu.com/docs/createApp/ '创建应用并开通push服务').
* 在应用信息页面找到当前app的api key及secure key.

> *** api_key (AK) *** : 一个应用的公钥及唯一标识.用于在调用百度各项开发者服务时标记出一个应用. 创建后不能修改. 
> 
> *** secure_key (SK) *** : 对应一个AK的密钥,用于在调用各项服务时生成签名或加密数据,开发者可以随时进行重置. 请务必确认SK的内容不会泄露给第三方,否则可能产生安全问题,如确认SK被泄露,请立即在开发者中心进行重置.

##Step 3 下载并安装快速DEMO

* Android 平台快速 Demo [http://push.baidu.com/docs/android-demo](http://push.baidu.com/docs/android-demo)
* iOS 平台快速 Demo [http://push.baidu.com/docs/android-demo](http://push.baidu.com/docs/ios-demo)
* 运行快速 demo , 并找到当前设备的 ***channel_id***

	> ***channel_id*** : channel_id是用于表示一台设备的唯一标识, 在推送消息时,用于指定消息的目标接收设备.

##Step 4 开发环境搭建

* 搭建PHP开发环境, 最低版本要求为 php 5.2, 环境配置过程请参见[PHP安装及配置指南](http://php.net/manual/zh/install.php, "php安装及配置指南")

* SDK依赖cUrl PHP扩展, 安装及配置过程请参见 [cUrl安装及配置指南](http://php.net/manual/zh/curl.setup.php, 'cUrl安装及配置指南'), 关于cUrl模块的更多信息可参考 [http://curl.haxx.se/](http://curl.haxx.se/)

##Step 5 使用PHP SDK推送一条消息
* 下载最新版PHP SDK开发包. [下载最新版](http://push.baidu.com/download/php-sdk.tar.gz) [源码位置](https://github.com/BaiduPush/phpsdk "source on github")

		> wget http://push.baidu.com/download/php-sdk.tar.gz
		
* 解压SDK内容.

		> tar zxvf php-sdk.tar.gz

* 修改configure.php中的default_apiKey及default_securekey,填入在Setp 2中获得的apikey及secure key.
	
	    /**
	     * 开发者apikey, 由开发者中心(http://developer.baidu.com)获取, 
	     * 当代码中未设置apikey时,使用此apikey
	     * @var string
	     */
	    const default_apiKey = 'Vek7uG4nhplvh3cpg2H5Ut50';
    
	    /**
	     * 开发者当前secureKey, 在应用重新生成secret key后, 旧的secret key将失效, 由开发者中心(http://developer.baidu.com)获取.
	     * 当代码中未设置apikey时,使用此securekey
	     * @var string
	     */
	    const default_securekey = 'NdxoxNykVrH6qA3CV33kzK7lsSTTvZA9';


* 修改configure.php中的test_channel_id, 填入在Setp 3中获得的channel_id

	    /**
	     * 用于接收测试消息的channel_id.
    	 * @var string
	     */
	    const test_channel_id = '3785562685113372034';

* 使用phpunit执行check_sdk_test.php进行环境测试, ** !这一步用于检测执行环境及配置,并不是必须的,但是可以用于确认执行环境可以执行正常.在任意情况下需要确认环境正常时, 都可以执行这一步操作. 当出现错误信息时,请参考 [PHP SDK错误状态]('PHPSDK 错误码') 排查相关问题.**

		> cd test
		> phpunit check_sdk_test.php
		
		 PHPUnit 4.4.1 by Sebastian Bergmann.
		 
		 .
		 SDK_HOME:/home/rd/phpsdk/
		 CONFIG_FILE:/home/rd/phpsdk/configure.php
		 
		 [INFO][1425960087][PUSH_SDK] PushSimpleLog: ready to work!; 
		 [INFO][1425960087][PUSH_SDK] HttpRequest: ready to work...; 
		 [INFO][1425960087][PUSH_SDK] SDK: initializing...; 
		 [INFO][1425960087][PUSH_SDK] SDK ready to work !!; 
		 [INFO][1425960088][PUSH_SDK] HttpRequest: 200 POST http://api.tuisong.baidu.com/rest/3.0/push/single_device; 
		 [INFO][1425960088][PUSH_SDK] Parse Response: 200, OK, {"request_id":804656752,"response_params":{"msg_id":"3570960677660087563","send_time":1425960086}}; 
		 .finish the test and every thing is good!
		 
		 
		 Time: 996 ms, Memory: 4.00Mb
		 
		 OK (2 tests, 6 assertions)
		  
* 如果配置信息及执行环境一切正常, 则可以看到以上测试结果, 同时将在安装快速demo的设备上收到一条通知消息.

## Step 6 开发第一个DEMO

* 在确认环境正常后, 将解压出的内容放置于项目工程目录能找到的位置. 具体可参见 [php include_path配置](http://php.net/manual/zh/ini.core.php#ini.include-path, "php include_path配置")
* 编写代码发送第一条消息. [demo](../demo/hello.php 'demo')
		 
		 require_once './phpsdk/sdk.php';
		 
		 // 创建SDK对象.
		 $sdk = new PushSDK();
		 
		 $channelId = '3785562685113372034';
		 
		 // 消息内容.
		 $message = array (
		     // 消息的标题.
		     'title' => 'Hi!.',
		     // 消息内容 
		     'description' => "hello!, this message from baidu push service." 
		 );
		 
		 // 设置消息类型为 通知类型.
		 $opts = array (
		     'msg_type' => 1 
		 );
		 
		 // 向目标设备发送一条消息
		 $rs = $sdk -> pushMsgToSingleDevice($channelId, $message, $opts);
		 
		 // 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
		 if($rs === false){
		    print_r($sdk->getLastErrorCode()); 
		    print_r($sdk->getLastErrorMsg()); 
		 }else{
		     // 将打印出消息的id,发送时间等相关信息.
		     print_r($rs);
		 }
		 
		 echo "done!";
		 
* 关于接口及SDK使用,请参考 [docs/PHPSDK_API.md](./api.md)
* 任何问题可以通过[README.me](../README.md)中的 "Bugs / Feature Requests" 中提供的联系方式进行相关反馈.
* 更多信息请至[http://push.baidu.com/docs](http://push.baidu.com/docs '百度云推送文档中心')中获取



*** Thanks & Best Regards! ***

=================
Copyright (c) 2015 Baidu.com, Inc. All Rights Reserved

