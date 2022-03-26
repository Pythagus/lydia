<?php

namespace Pythagus\Lydia\Contracts;

use Exception;
use Throwable;

/**
 * Class LydiaException
 * @package Pythagus\Lydia\Contracts
 *
 * @author: Damien MOLINA
 */
class LydiaException extends Exception {

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct(
            "Lydia : " . $message, $code, $previous
        ) ;
    }
}