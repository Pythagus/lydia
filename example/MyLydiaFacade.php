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

	/**
	 * Save the payment data to retrieve them
	 * to check the transaction state.
	 *
	 * @param array $data
	 */
	public function savePaymentData(array $data) {
		//
	}

}