<?php namespace Icepay\API;

/**
 * ICEPAY REST API for PHP
 *
 * @version     0.0.1
 * @authors     Ricardo Jacobs <ricardozegt@gmail.com>
 * @license     BSD-2-Clause, see LICENSE.md
 * @copyright   (c) 2015, ICEPAY B.V. All rights reserved.
 */

use Icepay\API\Resources\Payment;
use Icepay\API\Resources\Refund;

class Client
{
	/**
	 * @var $ch
	 */
	protected $ch;

	/**
	 * @var $api_key
	 */
	public $api_key;

	/**
	 * @var $api_secret
	 */
	public $api_secret;

	/**
	 * @var $api_completed_url
	 */
	public $api_completed_url;

	/**
	 * @var $api_error_url
	 */
	public $api_error_url;

	/**
	 * @var $api_endpoint string
	 */
	public $api_endpoint = 'https://connect.icepay.com/webservice/api/v1/';

	/**
	 * @var $api_version string
	 */
	public $api_version = '0.0.1';

	/**
	 * Supported curl methods
	 */
	public $api_get = "GET";
	public $api_post = "POST";

	/**
	 * Set the API Key and trim whitespaces
	 *
	 * @param $api_key
	 */
	public function setApiKey($api_key)
	{
		$this->api_key = trim($api_key);
	}

	/**
	 * Set the API Secret code and trim whitespaces
	 *
	 * @param $api_secret
	 */
	public function setApiSecret($api_secret)
	{
		$this->api_secret = trim($api_secret);
	}

	/**
	 * Set the completed url after a succesfull payment and trim whitespaces.
	 *
	 * @param $url
	 */
	public function setCompletedURL($url)
	{
		$this->api_completed_url = trim($url);
	}

	/**
	 * Set the error url after a error in the payment and trim whitespaces.
	 *
	 * @param $url
	 */
	public function setErrorURL($url)
	{
		$this->api_error_url = trim($url);
	}

	/**
	 * API Constructor
	 */
	public function __construct()
	{
		$this->payment = new Payment($this);
		$this->refund = new Refund($this);
	}

	/**
	 * Request function to call our API Rest Payment Server
	 *
	 * @param $method
	 * @param $api_method
	 * @param $body
	 * @param $checksum
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function request($method, $api_method, $body = NULL, $checksum)
	{
		/**
		 * Check if the Merchant ID is set
		 */
		if (empty($this->api_key)) {
			throw new \Exception("Please configure your ICEPAY Merchant ID.");
		}

		/**
		 * Check if the Secret Code is set
		 */
		if (empty($this->api_secret)) {
			throw new \Exception("Please configure your ICEPAY Secret Code.");
		}

		/**
		 * Check if the CompletedURL is set
		 */
		if (empty($this->api_completed_url)) {
			throw new \Exception("Please configure your setCompletedURL()");
		}

		/**
		 * Check if the ErrorURL is set
		 */
		if (empty($this->api_error_url)) {
			throw new \Exception("Please configure your setErrorURL()");
		}

		/**
		 * Start a curl session
		 */
		if (empty($this->ch) || !function_exists("curl_reset")) {
			$this->ch = curl_init();
		} else {
			curl_reset($this->ch);
		}

		/**
		 * Set the curl options
		 */
		curl_setopt($this->ch, CURLOPT_URL, $this->api_endpoint . $api_method);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);

		/**
		 * Possible output: 5.6.9
		 */
		$php_version = phpversion();

		/**
		 * Prepare the curl headers
		 */
		$api_headers = array(
			"MerchantID: {$this->api_key}",
			"Checksum: {$checksum}",
			"User-Agent: ICEPAY API/{$this->api_version} PHP/{$php_version}",
			"Accept: application/json"
		);

		/**
		 * If the body is not null, let curl post the request as json content
		 */
		if ($body !== NULL) {
			$api_headers[] = "Content-Type: application/json";

			curl_setopt($this->ch, CURLOPT_POST, 1);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($body));
		}

		/**
		 * Set the curl headers for the payment server
		 */
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $api_headers);

		/**
		 * Set the SSL options
		 */
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, TRUE);

		/**
		 * Execute the request
		 */
		$response = curl_exec($this->ch);

		/**
		 * Invalid or no certificate authority found, using bundled information
		 */
		if (curl_errno($this->ch) == 77 /* CURLE_SSL_CACERT_BADFILE */ || curl_errno($this->ch) == 60 /* CURLE_SSL_CACERT */) {
			curl_setopt($this->ch, CURLOPT_CAINFO, realpath(dirname(__FILE__) . '/Assets/icepay.pem'));

			$response = curl_exec($this->ch);
		}

		/**
		 * Verifying peer certificate fails on OpenSSL 0.9 or earlier.
		 * We done all we could to check the certificate on the host.
		 * This webserver simply will not accept it and we need to connect.
		 */
		if (strpos(curl_error($this->ch), 'certificate subject name') !== FALSE) {
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);

			$response = curl_exec($this->ch);
		}

		/**
		 * Check if we got any error, if so, exception it
		 */
		if (curl_errno($this->ch)) {
			curl_close($this->ch);
			$this->ch = NULL;

			throw new \Exception('Unable to reach the ICEPAY payment server (' . curl_errno($this->ch) . '):' . curl_error($this->ch));
		}

		/**
		 * Close the connection
		 */
		if (!function_exists("curl_reset")) {
			curl_close($this->ch);
			$this->ch = null;
		} else {
			curl_reset($this->ch);
			$this->ch = null;
		}

		/**
		 * Return the decoded json response
		 */
		return json_decode($response);
	}

	/**
	 * Close resources if they are open
	 */
	public function __destruct()
	{
		if (is_resource($this->ch)) {
			curl_close($this->ch);
		}
	}
}
