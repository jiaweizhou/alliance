<?php

namespace app\modules\v1\models;

class Easeapi {
	private $server_url = 'https://a1.easemob.com/';
	private $client_id;
	private $client_secret;
	private $org_name;
	private $app_name;
	private $app_url;
	private $access_token;
	public function __construct($client_id, $client_secret, $org_name, $app_name, $token_save = 'cookie') {
		$this->client_id 	= $client_id;
		$this->client_secret= $client_secret;
		$this->org_name 	= $org_name;
		$this->app_name		= $app_name;
		$this->app_url 		= $this->server_url.$this->org_name.'/'.$this->app_name;
		$this->access_token = $this->getToken($token_save);
	}

	public function getToken($token_save = 'cookie') {
		$params = array(
				'grant_type'	=> 'client_credentials',
				'client_id'		=> $this->client_id,
				'client_secret'	=> $this->client_secret
		);
		if ($token_save == 'cookie') {
			if(!isset($_COOKIE['access_token'])) {
				$result = json_decode($this->curl('/token', $params), true);
				setcookie('access_token', $result['access_token'], time() + $result['expires_in']);
				return $result['access_token'];
			} else {
				return $_COOKIE['access_token'];
			}
		}
		if($token_save == 'file') {
			$fp = @fopen('easeapi.txt', 'r');
			if ($fp) {
				$arr = unserialize(fgets($fp));
				if ($arr['expires_in'] < time()) {
					$result = $this->curl('/token', $params);
					$result['expires_in'] = $result['expires_in'] + time ();
					@fwrite($fp, serialize($result));
					return $result['access_token'];
					fclose($fp);
					exit();
				}
				return $arr['access_token'];
				fclose ($fp);
				exit ();
			}
			$result = $this->curl('/token', $params);
			$result = json_decode($result,true);
			$result ['expires_in'] = $result['expires_in'] + time ();
			$fp = @fopen('easeapi.txt', 'w');
			@fwrite($fp, serialize($result));
			return $result['access_token'];
			fclose($fp);
		}
	}
	public function createHttpHeader() {
		$header = array('Content-Type:application/json');
		if (!empty($this->access_token)) {
			array_push($header, "Authorization: Bearer ".$this->access_token);
		}
		return $header;
	}
	public function curl($action, $params, $type = 'POST') {
		$curl_session = curl_init();
		curl_setopt($curl_session, CURLOPT_URL, $this->app_url.$action);
		curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl_session, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl_session, CURLOPT_USERAGENT, 'Avcall Server');
		curl_setopt($curl_session, CURLOPT_ENCODING, 'gzip');
		if(!empty($params)){
			$param = json_encode($params);
			curl_setopt($curl_session, CURLOPT_POSTFIELDS, $param);
		}
		curl_setopt ($curl_session, CURLOPT_TIMEOUT, 30);
		curl_setopt ($curl_session, CURLOPT_HTTPHEADER, $this->createHttpHeader());
		curl_setopt ($curl_session, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($curl_session, CURLOPT_CUSTOMREQUEST, $type);
		$result = curl_exec ($curl_session);
		curl_close($curl_session);
		return $result;
	}

}