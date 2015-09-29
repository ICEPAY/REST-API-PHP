<?php namespace Icepay\API\Resources;

/**
 * ICEPAY REST API for PHP
 *
 * @version     0.0.1
 * @authors     Ricardo Jacobs <ricardozegt@gmail.com>
 * @license     BSD-2-Clause, see LICENSE.md
 * @copyright   (c) 2015, ICEPAY B.V. All rights reserved.
 */

use Icepay\API\Client;

class BaseApi
{
    /**
     * @var Client
     */
    public $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns the current timestamp
     *
     * @return string
     */
    public function getTimeStamp()
    {
        return gmdate("Y-m-d\TH:i:s\Z");
    }

    /**
     * Generates a checksum to sign the message
     *
     * @param $string
     * @return string
     */
    public function generateChecksum($string)
    {
        return hash('sha256', utf8_encode($string));
    }

    /**
     * Get the customers IP Address
     *
     * @return string
     */
    public function getClientIp()
    {
        return getenv('HTTP_CLIENT_IP') ?:
            getenv('HTTP_X_FORWARDED_FOR') ?:
                getenv('HTTP_X_FORWARDED') ?:
                    getenv('HTTP_FORWARDED_FOR') ?:
                        getenv('HTTP_FORWARDED') ?:
                            getenv('REMOTE_ADDR');
    }
}
