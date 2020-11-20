<?php

namespace Pythagus\Lydia\Traits;

use Throwable;

/**
 * Trait LydiaTools
 * @package Pythagus\Lydia\Traits
 *
 * @author: Damien MOLINA
 */
trait LydiaTools {

	/**
	 * We are trying to take the transaction_identifier
	 * token in the GET Lydia's response.
	 *
	 * @return string|null
	 */
	protected function getTransactionIdentifier() {
		try {
			return $_GET['transaction'] ?? null ;
		} catch(Throwable $ignored) {
			return null ;
		}
	}

}