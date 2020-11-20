<?php

namespace Pythagus\Lydia\Networking;

use Pythagus\Lydia\Lydia;
use Pythagus\Lydia\Traits\HasParameters;
use Pythagus\Lydia\Contracts\LydiaException;
use Pythagus\Lydia\Traits\HasLydiaProperties;

/**
 * Class LydiaRequest
 * @package Pythagus\Lydia\Networking
 *
 * @author: Damien MOLINA
 */
abstract class LydiaRequest {

	use HasParameters, HasLydiaProperties, ExternalRequest ;

	/**
	 * Execute the request.
	 *
	 * @return mixed
	 */
	abstract protected function run() ;

	/**
	 * Get a Lydia instance.
	 *
	 * @return Lydia
	 */
	protected function lydia() {
		return Lydia::getInstance() ;
	}

	/**
	 * Execute the request adding some parameters.
	 *
	 * @param array $parameters
	 * @return mixed
	 * @throws LydiaException
	 */
	public function execute(array $parameters = []) {
		$this->setDefaultParameters();
		$this->addPropertiesOnArray($this->getConfig('properties', [])) ;
		$this->addPropertiesOnArray($parameters) ;

		foreach($this->shouldHaveParameters() as $parameter) {
			if(! array_key_exists($parameter, $this->parameters)) {
				throw new LydiaException(class_basename($this) . " should have a parameter : $parameter") ;
			}
		}

		return $this->run() ;
	}

	/**
	 * Set the properties listed in the given array.
	 *
	 * @param array $properties
	 */
	protected function addPropertiesOnArray(array $properties) {
		foreach($properties as $key => $value) {
			$this->setParameter($key, $value) ;
		}
	}

	/**
	 * Check whether the Lydia response has the
	 * expected format.
	 *
	 * @param $response
	 * @param string $key
	 * @param bool $shouldHave
	 * @throws LydiaException
	 */
	protected function lydiaResponseContains($response, string $key, bool $shouldHave) {
		$has = isset($response->$key) ;

		/*
		 * There is an error if:
		 * -> The response should have the $key field and has not one.
		 * -> The response should not have the $key field and has one.
		 */
		if($shouldHave xor $has) {
			throw new LydiaException(
				"Lydia's response " . ($shouldHave ? "should" : "shouldn't") . " have $key attribute"
			) ;
		}
	}

	/**
	 * Generate the request signature.
	 *
	 * @param array $param
	 * @return string
	 * @see: https://lydia-app.com/doc/api/#signature
	 */
	protected function generateSignature(array $param) {
		/*
		 * We are making a copy of the
		 * given param to leave the given
		 * value intact.
		 */
		$data = $param ;

		// Alphabetical ordering
		ksort($data) ;

		return md5(
			http_build_query($data) . '&' . $this->getLydiaPrivateToken()
		) ;
	}

	/**
	 * Make a request server call.
	 *
	 * @param string $route : config key (lydia.url.$key) in lydia.php config file.
	 * @param array|null $params
	 * @return mixed
	 */
	protected function requestServer(string $route, array $params = null) {
		return $this->externalRequest(
			$this->getLydiaURL() . $this->getConfig('url.'.$route),
			$params ?? $this->parameters ?? null
		) ;
	}

}