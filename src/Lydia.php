<?php

namespace Pythagus\Lydia;

use Exception;
use Pythagus\Lydia\Traits\HasConfig;
use Pythagus\Lydia\Contracts\LydiaState;

/**
 * Class Lydia
 * @package Pythagus\Lydia
 *
 * @author: Damien MOLINA
 */
class Lydia implements LydiaState {

	use HasConfig ;

	/**
	 * The current globally available container (if any).
	 *
	 * @var Lydia
	 */
	protected static $instance ;

	public function __construct() {
		$this->configs = $this->setConfigArray() ;
	}

	/**
	 * Set the Lydia instance.
	 *
	 * @param Lydia $lydia
	 */
	public static function setInstance(Lydia $lydia) {
		Lydia::$instance = $lydia ;
	}

	/**
	 * Get the globally available instance of the Lydia
	 * facade.
	 *
	 * @return static
	 */
	public static function getInstance() {
		if(empty(Lydia::$instance)) {
			Lydia::$instance = new static ;
		}

		return Lydia::$instance ;
	}

	/**
	 * Get the Lydia's configuration.
	 *
	 * @return array
	 */
	protected function setConfigArray() {
		return [] ;
	}

	/**
	 * Redirect the user to the given route.
	 *
	 * @param string $route
	 * @return mixed
	 */
	public function redirect(string $route) {
		header('Location: '.$route) ;
		exit() ;
	}

	/**
	 * Format the callback URL to be valid
	 * regarding the Lydia server.
	 *
	 * @param string $url
	 * @return string
	 */
	public function formatCallbackUrl(string $url) {
		throw new Exception("Should override this method") ;
	}

}