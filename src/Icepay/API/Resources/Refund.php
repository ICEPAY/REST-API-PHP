<?php namespace Icepay\API\Resources;

class Refund extends BaseApi
{
    /**
     * @param $data
     * @return mixed
     */
    public function startRefund($data)
    {
        /**
         * Information for starting the refund
         */
        $information = array(
            'Timestamp' => $this->getTimeStamp(),
            'PaymentID' => $data['PaymentID'],
            'RefundAmount' => $data['Amount'],
            'RefundCurrency' => $data['Currency']
        );

        /**
         * Generate the checksum for the request
         */
        $checksum = $this->client->generateChecksum(
            $this->client->api_endpoint .
            'refund/requestrefund' .
            $this->client->api_post .
            $this->client->api_key .
            $this->client->api_secret .
            json_encode($information)
        );

        /**
         * Make the call.
         */
        return $this->client->request($this->client->api_post, 'refund/requestrefund', $information, $checksum);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function cancelRefund($data)
    {
        /**
         * Information for cancelling the refund
         */
        $information = array(
            'Timestamp' => $this->getTimeStamp(),
            'RefundID' => $data['RefundID'],
            'PaymentID' => $data['PaymentID']
        );

        /**
         * Generate the checksum for the request
         */
        $checksum = $this->client->generateChecksum(
            $this->client->api_endpoint .
            'refund/cancelrefund' .
            $this->client->api_post .
            $this->client->api_key .
            $this->client->api_secret .
            json_encode($information)
        );

        /**
         * Make the call.
         */
        return $this->client->request($this->client->api_post, 'refund/cancelrefund', $information, $checksum);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getRefundStatus($data)
    {
        /**
         * Information for cancelling the refund
         */
        $information = array(
            'Timestamp' => $this->getTimeStamp(),
            'PaymentID' => $data['PaymentID']
        );

        /**
         * Generate the checksum for the request
         */
        $checksum = $this->client->generateChecksum(
            $this->client->api_endpoint .
            'refund/getpaymentrefunds' .
            $this->client->api_post .
            $this->client->api_key .
            $this->client->api_secret .
            json_encode($information)
        );

        /**
         * Make the call.
         */
        return $this->client->request($this->client->api_post, 'refund/getpaymentrefunds', $information, $checksum);
    }
}
