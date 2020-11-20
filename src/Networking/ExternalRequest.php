<?php

namespace Pythagus\Lydia\Networking;

/**
 * Trait ExternalRequest
 * @package Pythagus\Lydia\Networking
 *
 * @author: Damien MOLINA
 */
trait ExternalRequest {

	/**
	 * Execute and transform the server request response.
	 *
	 * @param string $url
	 * @param array|null $param
	 * @param string $headerKey
	 * @param bool $assoc
	 * @return mixed
	 */
	protected function externalRequest(string $url, array $param = null, string $headerKey = '', bool $assoc = false) {
		return json_decode($this->cURL($url, $param, $headerKey), $assoc) ;
	}

	/**
	 * Make a CURL call.
	 *
	 * @param string $url
	 * @param array|null $param
	 * @param string $headerKey
	 * @return bool|string
	 */
	private function cURL(string $url, array $param = null, string $headerKey = '') {
		$header = "Content-type: application/x-www-form-urlencoded" ;

		if(strlen($headerKey) > 0) {
			$header .= "\r\n".$headerKey ;
		}

		$ch = curl_init() ;
		curl_setopt($ch, CURLOPT_URL, $url) ;
		curl_setopt_array($ch,[CURLOPT_HTTPHEADER=>[$header]]) ;
		curl_setopt($ch,CURLOPT_POST,true) ;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;

		if(! is_null($param)) {
			curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($param)) ;
		}

		$response = curl_exec($ch) ;
		curl_close($ch) ;

		return $response ;
	}

}