<?php

class Cardmatch_Log extends Zend_Log {


	public function logServer($action) {

		$serverId = $this->_getCookieValue('SERVERID');
		$serverId5 = $this->_getCookieValue('SERVERID5');
		$sessionId = session_id();
		$remoteIp = $this->getIp();
		$serverIp = $_SERVER['SERVER_ADDR'];

		$msg = "{$action} - Server ID: {$serverId} | Server ID5: {$serverId5} | Session ID: {$sessionId} | Server IP: {$serverIp} | Remote IP: {$remoteIp}";

		$this->info($msg);

	}


	private function _getCookieValue($name, $default = null) {

		$value = $default;

		if (isset($_COOKIE[$name])) {
			$value = $_COOKIE[$name];
		}

		return $value;

	}

	private function getIp() {
		//Just get the headers if we can or else use the SERVER global
		if (function_exists('apache_request_headers')) {
			$headers = apache_request_headers();
		} else {
			$headers = $_SERVER;
		}

		//Get the forwarded IP if it exists
		if (array_key_exists('X-Forwarded-For', $headers) && filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			$the_ip = $headers['X-Forwarded-For'];
		} elseif (array_key_exists('HTTP_X_FORWARDED_FOR', $headers) && filter_var($headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
		} else {

			$the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
		}
		return $the_ip;
	}


}