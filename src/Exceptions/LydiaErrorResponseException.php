<?php

namespace Pythagus\Lydia\Exceptions;

use Pythagus\Lydia\Contracts\LydiaException;

/**
 * Class LydiaErrorResponseException
 * @package Pythagus\Lydia\Exceptions
 *
 * @property int    code
 * @property string message
 *
 * @author: Damien MOLINA
 */
class LydiaErrorResponseException extends LydiaException {

    /**
     * Lydia error code.
     *
     * @var integer
     */
    public $code ;

    /**
     * The returned message.
     *
     * @var string
     */
    public $message ;

    /**
     * Make a new error exception.
     *
     * @param string $message : original exception message.
     * @param array $response
     */
    public function __construct(int $code, string $message) {
        $this->code    = $code ;
        $this->message = $message ;

        parent::__construct("$message (code $code)") ;
    }
}