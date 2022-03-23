<?php

namespace Pythagus\Lydia\Contracts;

/**
 * These error codes were generated from logs after
 * Lydia usages. This is not an exhaustive list.
 * 
 * Class LydiaErrorCode
 * @package Pythagus\Lydia\Contracts
 *
 * @author: Damien MOLINA
 */
interface LydiaErrorCode {

    /**
     * Invalid email address given (recipient).
     * 
     * @var integer
     */
    public const INVALID_RECIPIENT = 3 ;

    /**
     * The recipient cannot receive more payment requests.
     * 
     * @var integer
     */
    public const FLOODED_RECIPIENT = 4 ;

    /**
     * The recipient was blocked.
     * 
     * @var integer
     */
    public const BLOCKED_RECIPIENT = 6 ;

}