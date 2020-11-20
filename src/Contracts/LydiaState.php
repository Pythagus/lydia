<?php

namespace Pythagus\Lydia\Contracts;

/**
 * Interface LydiaState
 * @package Pythagus\Lydia\Contracts
 * @see https://lydia-app.com/doc/api/#api-Payment-State
 *
 * @author: Damien MOLINA
 */
interface LydiaState {

	/**
	 * Unknown transaction state.
	 *
	 * @const int
	 */
	public const UNKNOWN = -1 ;

	/**
	 * State of a waiting payment. A transaction
	 * request was addressed to Lydia.
	 *
	 * @const int
	 */
	public const WAITING_PAYMENT = 0 ;

	/**
	 * The payment was confirmed by Lydia.
	 *
	 * @const int
	 */
	public const PAYMENT_CONFIRMED = 1 ;

	/**
	 * The payment was refused by the bank.
	 *
	 * @const int
	 */
	public const REFUSED_BY_PAYER = 5 ;

	/**
	 * The payment was cancelled by the client
	 * before the end.
	 *
	 * @const int
	 */
	public const CANCELLED_BY_OWNER = 6 ;

}