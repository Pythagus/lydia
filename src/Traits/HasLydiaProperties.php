<?php

namespace Pythagus\Lydia\Traits;

use Pythagus\Lydia\Lydia;

/**
 * Trait HasLydiaProperties
 * @package Pythagus\Lydia\Traits
 *
 * @author: Damien MOLINA
 */
trait HasLydiaProperties {

	/**
	 * Determine whether the website is in a
	 * lydia debugging mode.
	 *
	 * @return bool
	 */
	protected function isTestingMode() {
		return boolval($this->getConfig('debug', false)) ;
	}

	/**
	 * Get the PaymentLydia server's URL
	 *
	 * @return string
	 */
	protected function getLydiaURL() {
		return $this->getLydiaCredential('url_server') ;
	}

	/**
	 * Get the PaymentLydia vendor token.
	 *
	 * @return string
	 */
	protected function getLydiaVendorToken() {
		return $this->getLydiaCredential('vendor_token') ;
	}

	/**
	 * Get the PaymentLydia private token.
	 *
	 * @return string
	 */
	protected function getLydiaPrivateToken() {
		return $this->getLydiaCredential('private_token') ;
	}

	/**
	 * Get the property in the lydia.php file
	 * using the debug value.
	 *
	 * @param string $property
	 * @return string
	 */
	protected function getLydiaCredential(string $property) {
		$mode = $this->isTestingMode() ? 'debug' : 'prod' ;

		return $this->getConfig('credentials.'.$mode.'.'.$property) ;
	}

	/**
	 * Get the config value.
	 *
	 * @param string $key
	 * @param null $default
	 * @return mixed|null
	 */
	protected function getConfig(string $key, $default = null) {
		return Lydia::getInstance()->config($key, $default) ;
	}

}