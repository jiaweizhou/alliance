<?php
/***************************************************************************
 * 
 * Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
/**
 * 
 * @file check_sdk_test.php
 * @encoding UTF-8
 * 
 * @date 2015年3月8日
 *
 */

if(!defined('PUSH_SDK_HOME')){
    define('PUSH_SDK_HOME', dirname(dirname(__FILE__)));
}

require_once PUSH_SDK_HOME . '/configure.php';
require_once PUSH_SDK_HOME . '/sdk.php';

// check environment&config
class CheckEnviromentTest extends PHPUnit_Framework_TestCase{
    
    function testConfig(){
        
        echo "\n";
        echo "SDK_HOME:" . PUSH_SDK_HOME . "\n";
        echo "CONFIG_FILE:" . PUSH_SDK_HOME . '/configure.php' . "\n\n";
        
        if(class_exists('BAIDU_PUSH_CONFIG')){
            $this->assertNotEmpty(BAIDU_PUSH_CONFIG::HOST, "BAIDU_PUSH_CONFIG::HOST not exists" );
            $this->assertNotEmpty(BAIDU_PUSH_CONFIG::default_apiKey, "BAIDU_PUSH_CONFIG::default_apiKey not exists");
            $this->assertNotEmpty(BAIDU_PUSH_CONFIG::default_secretkey, "BAIDU_PUSH_CONFIG::default_secretkey not exists");
        }else{
            echo "missing configure!";
            die();
        }
    }
    
    /**
     * @depends testConfig
     * @param string $channelId
     */
    function testSendMessage(){
        
        $channelId = null;
        $channelId = class_exists('BAIDU_PUSH_CONFIG') ? BAIDU_PUSH_CONFIG::test_channel_id : false;
        
        if(empty($channelId)){
            echo "BAIDU_PUSH_CONFIG::test_channel_id not exisist, ignore the testSendMessage! \n";
            return;
        }
        
        // creaete SDK instance at default. and there is will be use the default_apik and default_secretkey.
        $sdk = new PushSDK();
        
        // message content.
        $message =  array(
            'title' => 'Hi!.',
            'description' => "hello!, this message from baidu push service.",
        );
        
        // option, set the msg_type is notice;
        $opts = array (
            'msg_type' => 1,
        );
        
        //send out;
        $rs  = $sdk->pushMsgToSingleDevice($channelId,$message,$opts);
        
        // check the return;
        $this -> assertNotFalse($rs, $sdk -> getLastErrorMsg());
        $this -> assertNotNull($sdk -> getRequestId(),'missing request_id');
        $this -> assertTrue(array_key_exists('msg_id', $rs),'missing msg_id');
        
        echo ("finish the test and every thing is good!\n");
    }
    
}
