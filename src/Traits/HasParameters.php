<?php

namespace Pythagus\Lydia\Traits;

/**
 * Trait HasParameters
 * @package Pythagus\Lydia\Helpers
 *
 * @property array parameters
 *
 * @author: Damien MOLINA
 */
trait HasParameters {

    /**
     * Request parameters.
     *
     * @var array
     */
    protected $parameters = [] ;

    /**
     * Set the parameter to the given value.
     *
     * @param string $field
     * @param $value
     */
    public function setParameter(string $field, $value) {
        $this->parameters[$field] = $value ;
    }

    /**
     * Reset all the parameters.
     *
     * @return void
     */
    public function clearParameters() {
        $this->parameters = [] ;
    }

    /**
     * Get the list of required parameters for
     * the request.
     *
     * @return array
     */
    protected function shouldHaveParameters() {
        return [] ;
    }

    /**
     * Set the default parameters.
     *
     * @return void
     */
    protected function setDefaultParameters() {
        //
    }
}