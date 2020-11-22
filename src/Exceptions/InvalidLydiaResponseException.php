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
	 * Lydia's response.
	 *
	 * @var array
	 */
	private $response ;

	/**
	 * Make a new InvalidLydiaResponse exception.
	 *
	 * @param string $message : original exception message.
	 * @param array $response
	 */
	public function __construct(string $message, array $response) {
		$this->response = $response ;

		parent::__construct(
			$this->formatMessage($message)
		) ;
	}

	/**
	 * Format the given response.
	 *
	 * @param string $message
	 * @return string
	 */
	private function formatMessage(string $message) {
		return $message . '(response : ' . json_encode($this->response) . ')' ;
	}

}