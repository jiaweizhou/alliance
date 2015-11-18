<?php
/**
 * *************************************************************************
 *
 * Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved
 *
 * ************************************************************************
 */
/**
 *
 * @file debug.php
 * @encoding UTF-8
 * 
 * 
 *         @date 2014年12月25日
 *        
 */

if(!defined('PUSH_SDK_HOME')){
    define('PUSH_SDK_HOME', dirname(dirname(__FILE__)));
}

include_once PUSH_SDK_HOME.'/lib/PushSimpleLog.php';
/**
 * 取得根据http状态码取得对应的默认状态消息
 * @param unknown $code
 */
function send_http_status($code) {
    static $_status = array (
        
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',
        
        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        
        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Moved Temporarily ', // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        
        // 306 is deprecated but reserved
        307 => 'Temporary Redirect',
        
        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        
        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded', 
    );
    if (array_key_exists($code, $_status)) {
        header('HTTP/1.1 ' . $code . ' ' . $_status [$code]);
    }
}

$log = new PushSimpleLog('stdout',0);

if(array_key_exists('q', $_REQUEST)){
    
    $log->log(print_r($_REQUEST['q'],true));
    
    switch($_REQUEST['q']){
        case "404_1":
            send_http_status(404);
            echo '{"request_id":100, "error_code":10000 , "error_msg":"what is that??"}';
            break;
        case "404_2":
            send_http_status(404);
            echo 'what is this??';
            break;
        case "200_1":
            send_http_status(200);
            echo '{"request_id":100, "response_params":[1,2,3,4]}';
            break;
        case "200_2":
            send_http_status(200);
            echo 'what is this??';
        case "200_3":
            send_http_status(200);
            echo '{"request_id":100, "error_code":4567}';
            break;
        case 'checkSign' :
            send_http_status(200);
            $rs = array(
                'request_id' => 100,
                'response_params' => $_REQUEST,
            );
            echo json_encode($rs);
            break;
        default:
            send_http_status(204);
    }
}else{
    $log->log(print_r($_REQUEST,true));
    echo json_encode($_REQUEST);
}