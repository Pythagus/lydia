<?php

namespace Pythagus\Lydia\Networking\Requests;

use Exception;
use Pythagus\Lydia\Lydia;
use Pythagus\Lydia\Networking\LydiaRequest;
use Pythagus\Lydia\Contracts\LydiaException;
use Pythagus\Lydia\Exceptions\InvalidLydiaResponseException;

/**
 * Class PaymentRequest
 * @package Pythagus\Lydia\Networking\Requests
 *
 * @property string url
 *
 * @author: Damien MOLINA
 */
class PaymentRequest extends LydiaRequest {

	/**
	 * Redirection url.
	 *
	 * @var string
	 */
	protected $url ;

	/**
	 * Execute the request.
	 *
	 * @return mixed
	 * @throws LydiaException
	 */
	protected function run() {
		$result = $this->requestServer('do') ;

		/**
		 * This method prevents to the Lydia problems that
		 * can occurred. The incoming exception should not
		 * be caught here to be printed to the client.
		 *
		 * @throws LydiaException
		 */
		$this->lydiaResponseContains($result, [
			'error', 'mobile_url', 'request_uuid', 'request_id'
		], true) ;

		/*
		 * Here, the response should be a Std object
		 * with keys:
		 * - error: Set to 0 if there is no error.
		 * - request_id: id of the request. You may need it to cancel the request.
		 * - request_uuid: UUID of the request. You may need it to check the request sate.
		 * - message: State of the request.
		 * - mobile_url: An url where you can redirect your user to let them pay. Lydia will
		 *   handle if they already have an account or show the a credit card payment form.
		 * - order_ref: Only if an order_ref was specified.
		 */
		$this->url = $result['mobile_url'] ;

		try {
			return [
				'state'        => Lydia::WAITING_PAYMENT,
				'url'          => $this->url,
				'request_id'   => $result['request_id'],
				'request_uuid' => $result['request_uuid'],
			] ;
		} catch(Exception $exception) {
			throw new InvalidLydiaResponseException($exception->getMessage(), $result) ;
		}
	}

	/**
	 * Get the list of required parameters for
	 * the request.
	 *
	 * @return array
	 */
	protected function shouldHaveParameters() {
		return ['recipient', 'amount'] ;
	}

	/**
	 * Set the default parameters.
	 *
	 * @return void
	 */
	protected function setDefaultParameters() {
		/*
		 * Vendor token of the business that done the request
		 * (if it's a request for a business)
		 */
		$this->setParameter('vendor_token', $this->getLydiaVendorToken()) ;

		// recipient type - Allowed values: email, phone
		$this->setParameter('type', 'email') ;

		/*
		 * Skip the Lydia confirmation page if browser_success_url is
		 * also set. This parameter is optional, accepted values are "yes" and "no",
		 * default is "yes".
		 */
		$this->setParameter('display_confirmation', 'no') ;

		/*
		 * Defines how the payment should be made: 'lydia' send a payment request to the lydia
		 * user's phone or send him to a download page if he doesn't have the app. 'cb' redirect
		 * the user to a classic credit card payment form. 'auto' either 'lydia' or 'cb' depending
		 * on whether or not a lydia account is associated with this mobile number
		 */
		$this->setParameter('payment_method', 'cb') ;

		// the payer of the payment request by SMS
		$this->setParameter('notify', 'no') ;

		// send an email to the business owner when the request is accepted by the payer
		$this->setParameter('notify_collector', 'no') ;

		/*
		 * duration in seconds after which the payment request becomes invalid. This duration can't
		 * exceed 7 days (604 800). If the value is up to 604800, the request will automatically
		 * expire on the 7th day.
		 */
		$this->setParameter('expire_time', '600') ;
	}

	/**
	 * Redirect the client to the Lydia website.
	 *
	 * @return mixed
	 * @throws LydiaException
	 */
	public function redirect() {
		if(is_null($this->url)) {
			throw new LydiaException("Impossible to redirect to Lydia's server") ;
		}

		return $this->lydia()->redirect($this->url) ;
	}

	/**
	 * Set the callback when the user is redirected.
	 *
	 * @param string $url
	 */
	public function setFinishCallback(string $url) {
		$route = $this->formatCallbackUrl($url) ;

		$this->setParameter('confirm_url', $route) ;
		$this->setParameter('cancel_url', $route) ;
		$this->setParameter('end_mobile_url', $route) ;
		$this->setParameter('browser_success_url', $route) ;
		$this->setParameter('browser_fail_url', $route) ;
	}

	/**
	 * Format the callback URL to be valid
	 * regarding the Lydia server.
	 *
	 * @param string $url
	 * @return string
	 */
	private function formatCallbackUrl(string $url) {
		return $this->lydia()->formatCallbackUrl($url) ;
	}

}