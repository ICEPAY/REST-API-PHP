<?php namespace Icepay\API\Resources;

class Payment extends BaseApi
{
    /**
     * @param $data
     * @return mixed
     */
    public function checkout($data)
    {
        $body = $this->getNewPaymentBody($data);
        return $this->request($this->client->api_post, 'payment/checkout', $body);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function vaultCheckout($data)
    {
        $body = $this->getNewPaymentBody($data);
        return $this->request($this->client->api_post, 'payment/vaultcheckout', $body);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function autoCheckout($data)
    {
        $body = $this->getNewPaymentBody($data);
        return $this->request($this->client->api_post, 'payment/automaticcheckout', $body);
    }

    /**
     * @return mixed
     */
    public function getMyPaymentMethods()
    {
        $body = [
            'Timestamp' => $this->getTimeStamp()
        ];

        return $this->request($this->client->api_post, 'payment/getmypaymentmethods', $body);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getPayment($data)
    {
        $body = [
            'Timestamp' => $this->getTimeStamp(),
            'PaymentID' => $data['PaymentID']
        ];

        return $this->request($this->client->api_post, 'payment/getpayment', $body);
    }

    public function forwardPayment($data)
    {
        $body = [
            'Timestamp' => $this->getTimeStamp(),
        ];

        foreach ([
                     'PaymentID',
                     'ForwardToIBAN',
                     'ForwardToBIC',
                     'ForwardToBeneficiary',
                     'ForwardToMerchantID',
                     'Amount',
                     'Description'
                 ] as $key) {
            if (isset($data[$key])) {
                $body[$key] = $data[$key];
            }
        }

        return $this->request($this->client->api_post, 'payment/forward', $body);
    }

    /**
     * @param $data
     * @return array
     */
    protected function getNewPaymentBody($data): array
    {
        $data = (array)$data;
        $result = [
            'Timestamp' => $this->getTimeStamp(),
            'Amount' => $data['Amount'],
            'Country' => $data['Country'],
            'Currency' => $data['Currency'],
            'Description' => $data['Description'],
            'Issuer' => $data['Issuer'],
            'Language' => $data['Language'],
            'OrderID' => $data['OrderID'],
            'PaymentMethod' => $data['Paymentmethod'],
            'Reference' => $data['Reference'],
            'URLCompleted' => $this->client->api_completed_url,
            'URLError' => $this->client->api_error_url,
            'EndUserIP' => $this->getClientIp()
        ];

        foreach (['ConsumerID', 'CustomerID', 'MerchantClientID'] as $key) {
            if (isset($data[$key])) {
                $result[$key] = $data[$key];
            }
        }

        return  $result;
    }
}
