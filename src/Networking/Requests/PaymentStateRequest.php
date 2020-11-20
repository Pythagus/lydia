<?php

namespace Pythagus\Lydia\Networking\Requests;

use Pythagus\Lydia\Networking\LydiaRequest;
use Pythagus\Lydia\Contracts\LydiaException;

/**
 * Class PaymentStateRequest
 * @package Pythagus\Lydia\Networking\Requests
 *
 * @property string requestUUID
 *
 * @author: Damien MOLINA
 */
class PaymentStateRequest extends LydiaRequest {

	/**
	 * Request UUID to check.
	 * This attribute was given in the PaymentRequest response.
	 *
	 * @var string
	 */
	private $requestUUID ;

	/**
	 * @param string $requestUUID
	 */
	public function __construct(string $requestUUID) {
		$this->requestUUID = $requestUUID ;
	}

	/**
	 * Execute the request.
	 *
	 * @return mixed
	 * @throws LydiaException
	 */
	protected function run() {
		$result = $this->requestServer('state') ;

		/**
		 * This method prevents to the Lydia problems that
		 * can occurred. The incoming exception should not
		 * be caught here to be printed to the client.
		 *
		 * @throws LydiaException
		 */
		$this->lydiaResponseContains($result, 'error', false) ;
		$this->lydiaResponseContains($result, 'state', true) ;

		/*
		 * Here, the response should be a Std object
		 * with keys:
		 * - state: Status of the remote request. See LydiaState contract interface.
		 * - used_ease_of_payment: Specify if the user used ease of payment or not.
		 */
		return intval($result->state) ;
	}

	/**
	 * Set the default parameters.
	 *
	 * @return void
	 */
	protected function setDefaultParameters() {
		// Vendor token of the business that done the request.
		$this->setParameter('vendor_token', $this->getLydiaVendorToken()) ;

		// UUID of the remote payment request.
		$this->setParameter('request_uuid', $this->requestUUID) ;
	}

}