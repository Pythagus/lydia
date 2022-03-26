<?php

namespace Pythagus\Lydia\Http;

use Pythagus\Lydia\Contracts\LydiaException;

/**
 * Class RefundRequest
 * @package Pythagus\Lydia\Http
 *
 * @property string identifier
 *
 * @author: Damien MOLINA
 */
class RefundRequest extends LydiaRequest {

	/**
	 * Payment identifier given in the
	 * Lydia return after a payment.
	 *
	 * @var string
	 */
	private $identifier ;

	/**
	 * @param string $identifier
	 */
	public function __construct(string $identifier) {
		$this->identifier = $identifier ;
	}

	/**
	 * Execute the request.
	 *
	 * @return mixed
	 * @throws LydiaException
	 */
	protected function run() {
		$this->setRequestParameters() ;

		$result = $this->requestServer('refund') ;

		/**
		 * This method prevents to the Lydia problems that
		 * can occurred. The incoming exception should not
		 * be caught here to be printed to the client.
		 *
		 * @throws LydiaException
		 */
		$this->lydiaResponseContains($result, 'error', true) ;

		/*
		 * Here, the response should be a Std object
		 * with keys:
		 * - error: Set to 0 if there is no error.
		 */
		return $result['error'] ;
	}

	/**
	 * Get the list of required parameters for
	 * the request.
	 *
	 * @return array
	 */
	protected function shouldHaveParameters() {
		return ['amount'] ;
	}

	/**
	 * Set the default parameters.
	 *
	 * @return void
	 */
	protected function setRequestParameters() {
		$amount = $this->parameters['amount'] ;

		$this->clearParameters() ;
		$this->setParameter('transaction_identifier', $this->identifier) ;
		$this->setParameter('amount', $amount) ;
		$this->setParameter('signature', $this->generateSignature($this->parameters)) ;
		$this->setParameter('vendor_token', $this->getLydiaVendorToken()) ;
	}
}