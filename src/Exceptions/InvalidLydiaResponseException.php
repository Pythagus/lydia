<?php

namespace Pythagus\Lydia\Exceptions;

use Pythagus\Lydia\Contracts\LydiaException;

/**
 * Class InvalidLydiaResponseException
 * @package Pythagus\Lydia\Exceptions
 *
 * @property array response
 *
 * @author: Damien MOLINA
 */
class InvalidLydiaResponseException extends LydiaException {

	/**
	 * Make a new InvalidLydiaResponse exception.
	 *
	 * @param string $message : original exception message.
	 * @param array $response
	 */
	public function __construct(string $message, array $response) {
		parent::__construct(
			$message . '(response : ' . json_encode($response) . ')'
		) ;
	}
}