<?php

namespace Pythagus\Lydia\Http;

use anlutro\cURL\cURL;
use Pythagus\Lydia\Lydia;
use Pythagus\Lydia\Traits\HasParameters;
use Pythagus\Lydia\Contracts\LydiaException;
use Pythagus\Lydia\Traits\HasLydiaProperties;
use Pythagus\Lydia\Exceptions\InvalidLydiaResponseException;

/**
 * Class LydiaRequest
 * @package Pythagus\Lydia\Http
 *
 * @author: Damien MOLINA
 */
abstract class LydiaRequest {

    use HasParameters, HasLydiaProperties ;

    /**
     * Execute the request.
     *
     * @return mixed
     */
    abstract protected function run() ;

    /**
     * Get a Lydia instance.
     *
     * @return Lydia
     */
    protected function lydia() {
        return Lydia::getInstance() ;
    }

    /**
     * Execute the request adding some parameters.
     *
     * @param array $parameters
     * @return mixed
     * @throws LydiaException
     */
    public function execute(array $parameters = []) {
        $this->setDefaultParameters();
        $this->addPropertiesOnArray($this->getConfig('properties', [])) ;
        $this->addPropertiesOnArray($parameters) ;

        foreach($this->shouldHaveParameters() as $parameter) {
            if(! array_key_exists($parameter, $this->parameters)) {
                throw new LydiaException(class_basename($this) . " should have a parameter : $parameter") ;
            }
        }

        return $this->run() ;
    }

    /**
     * Set the properties listed in the given array.
     *
     * @param array $properties
     */
    protected function addPropertiesOnArray(array $properties) {
        foreach($properties as $key => $value) {
            $this->setParameter($key, $value) ;
        }
    }

    /**
     * Check whether the Lydia response has the
     * expected format.
     *
     * @param array $response
     * @param $keys
     * @param bool $shouldHave
     * @throws LydiaException
     */
    protected function lydiaResponseContains(array $response, $keys, bool $shouldHave) {
        if(! is_array($keys)) {
            $keys = [$keys] ;
        }

        /*
         * We test every keys contained in
         * the $keys variable.
         */
        foreach($keys as $key) {
            $has = isset($response[$key]) ;

            /*
             * There is an error if:
             * -> The response should have the $key field and has not one.
             * -> The response should not have the $key field and has one.
             */
            if($shouldHave xor $has) {
                throw new InvalidLydiaResponseException(
                    "Lydia's response " . ($shouldHave ? "should" : "shouldn't") . " have $key attribute", $response
                ) ;
            }
        }
    }

    /**
     * Generate the request signature.
     *
     * @param array $param
     * @return string
     * @see: https://lydia-app.com/doc/api/#signature
     */
    protected function generateSignature(array $param) {
        /*
         * We are making a copy of the
         * given param to leave the given
         * value intact.
         */
        $data = $param ;

        // Alphabetical ordering
        ksort($data) ;

        return md5(
            http_build_query($data) . '&' . $this->getLydiaPrivateToken()
        ) ;
    }

    /**
     * Make a request server call.
     *
     * @param string $route : config key (lydia.url.$key) in lydia.php config file.
     * @return array
     */
    protected function requestServer(string $route) {
        $response = (new cURL())->post(
            $this->getLydiaURL() . $this->getConfig('url.' . $route), $this->parameters
        ) ;

        return json_decode($response->getBody(), true) ;
    }
}