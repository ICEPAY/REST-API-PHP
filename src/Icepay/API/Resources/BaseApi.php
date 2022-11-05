<?php namespace Icepay\API\Resources;

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
     * Get the customers IP Address
     *
     * @return string
     */
    public function getClientIp()
    {
        $ipaddress = getenv('HTTP_CLIENT_IP') ?:
            getenv('HTTP_X_FORWARDED_FOR') ?:
                getenv('HTTP_X_FORWARDED') ?:
                    getenv('HTTP_FORWARDED_FOR') ?:
                        getenv('HTTP_FORWARDED') ?:
                            getenv('REMOTE_ADDR');

	//Try to get client IP from SERVER variables
        if(!$ipaddress)
        {
            return $this->getClientIpFromServerVar();
        }
        return $ipaddress;
    }


    /**
     * Get the customers IP address from server variables
     *
     * @return string
     */
    public function getClientIpFromServerVar()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    /**
     * @param array $body
     * @return string
     */
    protected function generateChecksum(string $api_method, array $body): string
    {
        return $this->client->generateChecksum(
            $this->client->api_endpoint .
            $api_method .
            $this->client->api_post .
            $this->client->api_key .
            $this->client->api_secret .
            json_encode($body)
        );
    }

    protected function request($method, $api_method, $body = NULL, $checksum)
    {
        $checksum = $this->generateChecksum($api_method, $body);
        return $this->client->request($this->client->api_post, $api_method, $body, $checksum);
    }
}
