<?php

use Pythagus\Lydia\Lydia;

/**
 * Class MyLydiaFacade
 *
 * @author: Damien MOLINA
 */
class MyLydiaFacade extends Lydia {

	/**
	 * Get the Lydia's configuration.
	 *
	 * @return array
	 */
	protected function setConfigArray() {
		return require __DIR__ . '/lydia.php' ;
	}

	/**
	 * Format the callback URL to be valid
	 * regarding the Lydia server.
	 *
	 * @param string $url
	 * @return string
	 */
	public function formatCallbackUrl(string $url) {
		return 'https://www.google.com/' . $url ;
	}

}