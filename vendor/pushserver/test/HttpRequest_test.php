<?php
/***************************************************************************
 * 
 * Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
/**
 * 
 * @file test_HttpRequest.php
 * @encoding UTF-8
 * 
 * @date 2014年12月27日
 *
 */

if(!defined('PUSH_SDK_HOME')){
    define('PUSH_SDK_HOME', dirname(dirname(__FILE__)));
}

include_once PUSH_SDK_HOME.'/lib/HttpRequest.php';

class HttpRequestTest extends PHPUnit_Framework_TestCase{
    
    private $payload = array (
        'a' => 100,
        'b' => 200,
        'c' => '!@#$%^&*()',
        '中文' => '中文结果',
    );
    
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
     * @return
     */
    public function testCreateHttpRequest(){
        $log = new PushSimpleLog('stdout',0);
        $http = new HttpRequest("http://127.0.0.1:9890/", null, $log);
        return $http;
    }
    /**
     * @param array $res
     */
    private function valiedResponse($res){
        extract($res);
    
        $this->assertEquals(200, intval($status));
    
        $rsObj = json_decode($content, true);
        
        $this -> assertNotEmpty($rsObj);
        
        foreach($this->payload as $key => $value){
            $this -> assertEquals($rsObj [$key], $value);
        }
    }
  
    /**
     * @depends testCreateHttpRequest
     * @param HttpRequest $http
     */
    public function testGet($http){
        $rs = $http -> get('httpServer.php', $this -> payload);
        $this->valiedResponse($rs);
    }
    
    /**
     * @depends testCreateHttpRequest
     * @param HttpRequest $http
     */
    public function testPost($http){
        $rs = $http -> post('httpServer.php', $this -> payload);
        $this->valiedResponse($rs);
    }
    
    /**
     * @depends testCreateHttpRequest
     * @param HttpRequest $http
     */
    public function testResolve($http){
        $this->assertEquals("http://127.0.0.1:9890/", $http -> resolve("http://127.0.0.1:9890/"));
        $this->assertEquals("http://127.0.0.1:9890/httpServer.php", $http -> resolve("httpServer.php"));
    }
}
