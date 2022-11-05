<?php namespace Icepay\API\Resources;

class Refund extends BaseApi
{
    /**
     * @param $data
     * @return mixed
     */
    public function startRefund($data)
    {
        $information = array(
            'Timestamp' => $this->getTimeStamp(),
            'PaymentID' => $data['PaymentID'],
            'RefundAmount' => $data['Amount'],
            'RefundCurrency' => $data['Currency']
        );

        return $this->request($this->client->api_post, 'refund/requestrefund', $information);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function cancelRefund($data)
    {
        $information = array(
            'Timestamp' => $this->getTimeStamp(),
            'RefundID' => $data['RefundID'],
            'PaymentID' => $data['PaymentID']
        );

        return $this->request($this->client->api_post, 'refund/cancelrefund', $information);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getRefundStatus($data)
    {
        $information = array(
            'Timestamp' => $this->getTimeStamp(),
            'PaymentID' => $data['PaymentID']
        );

        return $this->request($this->client->api_post, 'refund/getpaymentrefunds', $information);
    }
}
