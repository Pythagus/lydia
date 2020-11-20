<?php

namespace Pythagus\Lydia\Traits;

use Pythagus\Lydia\Contracts\LydiaException;

/**
 * Trait HasConfig
 * @package Pythagus\Lydia\Traits
 *
 * @property array configs
 *
 * @author: Damien MOLINA
 */
trait HasConfig {

	/**
	 * Lydia's configurations
	 *
	 * @var array
	 */
	private $configs = [] ;

	/**
	 * Get the config value identified by
	 * the given key.
	 *
	 * @param string $key
	 * @param null $default
	 * @return mixed|null
	 */
	public function config(string $key, $default = null) {
		$array = $this->configs ;

		if(count($array) <= 0) {
			throw new LydiaException("No configs are loaded") ;
		}

		if(array_key_exists($key, $array)) {
			return $array[$key] ;
		}

		if(strpos($key, '.') === false) {
			return $array[$key] ?? $default ;
		}

		foreach(explode('.', $key) as $segment) {
			if(array_key_exists($segment, $array)) {
				$array = $array[$segment] ;
			} else {
				return $default ;
			}
		}

		return $array ;
	}

}