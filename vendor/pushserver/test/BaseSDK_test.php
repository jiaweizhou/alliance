<?php
/***************************************************************************
 * 
 * Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
/**
 * 
 * @file test_BaseSDK.php
 * @encoding UTF-8
 * 
 * @date 2014年12月31日
 *
 */
if(!defined('PUSH_SDK_HOME')){
    define('PUSH_SDK_HOME', dirname(dirname(__FILE__)));
}

require_once PUSH_SDK_HOME.'/lib/BaseSDK.php';

class TestSdk extends BaseSDK{
    /**
     * 自动调用
     * @param mixed $name
     * @param mixed $args
     * @return mixed
     */
    function __call($name,$args){
        return call_user_func_array( array($this, $name), $args);
    }
}


class BaseSDKTest extends PHPUnit_Framework_TestCase{
    
    private $testUrl = 'http://127.0.0.1:8080/debug.php';
    
    public function testCurl(){
        $this->AssertTrue(is_callable('curl_version'), "php extension [cUrl] is not exists!!");
        return true;
    }
    /**
     * @depends testCurl
     */
    public function testServerReady(){
        exec('curl --head http://127.0.0.1:9890', $out);
        $failedMsg = "
    Error: the Test server not runing!!
    
    please make sure the test server runing at the 127.0.0.1:9890, \n
    to start the test server by commend 'php -S 0.0.0.0:9890' in the test directory. \n\n";
        $this -> assertTrue(count($out) > 0, $failedMsg);
        return true;
    }
    
    /**
     * @depends testServerReady
     * @return TestSdk
     */
    public function testCreateBaseSdk(){
        return new TestSdk();
    }
    
    /**
     * @depends testCreateBaseSdk
     * @param BaseSDK $sdk
     */
    public function testSendHttpGet($sdk){
        $rs = $sdk->http->get($this->testUrl);
        extract($rs);
        $this->assertEquals(200, intval($status));
    }
    
    
    /**
     * @depends testCreateBaseSdk
     * @param BaseSDK $sdk
     */
    public function testSendHttpPost($sdk){
        $rs = $sdk->http->post($this->testUrl);
        extract($rs);
        $this->assertEquals(200, intval($status));
    }
    
    /**
     * @depends testCreateBaseSdk
     * @param BaseSDK $sdk
     */
    public function testParseResponse200($sdk){
        // test right response 200
        $response = $sdk -> http -> post($this -> testUrl, array (
            'q' => '200_1',
        ));
        
        $rs = $sdk->parse($response);
        $this->assertCount(4,$rs);
        
        // test wrong response 200
        $response = $sdk -> http -> post($this -> testUrl, array (
            'q' => '200_2',
        ));
        
        $rs = $sdk->parse($response);
        $this->assertFalse($rs); // will be false
        $this->assertEquals(null, $sdk->getRequestId());
        $this->assertEquals(4, $sdk->getLastErrorCode());
        $this->assertEquals($sdk->getLastErrorMsg(),"http status is ok, but REST returned invalid json string.");
        
        // test wrong json struct 200
        $response = $sdk -> http -> post($this -> testUrl, array (
            'q' => '200_3',
        ));
        
        $rs = $sdk -> parse($response);
        $this -> assertFalse($rs); // will be false
        
        $this -> assertEquals(100, $sdk -> getRequestId());
        $this -> assertEquals(4, $sdk -> getLastErrorCode());
        $this -> assertEquals($sdk -> getLastErrorMsg(), "http status is ok, but REST returned invalid json struct.");
    }
    
    /**
     * @depends testCreateBaseSdk
     * @param BaseSDK $sdk
     */
    public function testParseResponse404($sdk){
        // test right response 404
        $response = $sdk -> http -> post($this -> testUrl, array (
            'q' => '404_1',
        ));
        
        $rs = $sdk->parse($response);
        $this->assertFalse($rs); // will be false
        $this->assertEquals(100, $sdk->getRequestId());
        $this->assertEquals(10000, $sdk->getLastErrorCode());
        $this->assertEquals($sdk->getLastErrorMsg(), "what is that??"); // the message is server returned;
        
        // test wrong response 404
        $response = $sdk -> http -> post($this -> testUrl, array (
            'q' => '404_2',
        ));
        
        $rs = $sdk->parse($response);
        $this->assertFalse($rs); // will be false
        $this->assertEquals(null, $sdk->getRequestId());
        // same to access the wrong address return http status 404;
        $this->assertEquals(404, $sdk->getLastErrorCode());
        $this->assertNotNull($sdk->getLastErrorMsg());
    }
    /**
     * @depends testCreateBaseSdk
     * @param BaseSDK $sdk
     */
    public function testSendRequest($sdk){
        
        $rs = $sdk -> sendRequest($this -> testUrl, array (
            'q' => 'checkSign',
            'a' => 100,
            'b' => 200,
        ));
        
        $this->assertNotNull($rs); // will be null
        $sign = $rs['sign'];
        
        unset($rs['sign']);
        
        $checkSign = $sdk->genSign('POST', $this->testUrl, $rs);
        
        $this->assertEquals($sign,$checkSign,'check sign failed!');  
    }
}
 
 