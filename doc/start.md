## Starting your implementation

### REST and JSON

REST (REpresentational State Transfer) is a web service architectural style. In general it means that aspects of the HTTP protocol are used to retrieve or manipulate data from a remote system. As in HTTP, a RESTful API is called with the combination of a URL and a verb. The verb indicates the type of action that is requested:

  - A GET verb means read-only retrieval of information,
  - Verbs such as POST, PUT and DELETE indicate adding, changing or removing data.

Since most operations involve performing a payment or refund, the verb POST is used by nearly all operations on the ICEPAY REST API.

JSON (JavaScript Object Notation) is a notation style to represent complex object structures in a serialized manner (i.e. transferable over the internet). It has the same role as XML, but is much less verbose and therefore faster.

### Security

The ICEPAY REST API uses two layers of security to ensure two-way authentication of sender and receiver, and to prevent interception of messages and tampering.

SSL is used for transport security. All calls to the REST API must be done over HTTPS, ensuring end-to-end encryption of the message and authentication of ICEPAY as the recipient of your requests. A custom checksum algorithm using SHA256 is used to sign requests and responses. Using a pre-shared secret code, this algorithm authenticates the sender of requests and ensures that any response you receive really came from ICEPAY.

### Important considerations during implementation

  - ICEPAY’s services are hosted in Microsoft Azure where we employ multiple geographical locations to optimize performance. This means that calls from your webshop might be assigned to a specific geographic location. The public IP address from which ICEPAY communicates to your webshop may therefore vary. Do not employ any form of IP whitelisting in your implementation. To verify the authenticity of responses and postbacks from ICEPAY, the checksum should always be used.
  - All of ICEPAY’s payment services make use of secured connections. This means ICEPAY has an up to date SSL certificate that needs to be renewed every year. Do not cache any data regarding the SSL certificate as we may need to renew or replace the SSL certificate at any moment. To verify the identity of the ICEPAY service, validate the certificate itself with its root CA.
  - As our service continuously improves, we may need to add more parameters to request and response messages. Whenever possible any new request parameters will always be optional, but new response parameters may be added at any time. Ensure that your implementation does not break when receiving previously unknown parameters in the response.

### How to make a request to the API

To make a basic Checkout call, a message must be sent to the API with the following information:

  - The API URL
  - The HTTP verb POST
  - The Content-Type application/json
  - HTTP headers MerchantID and Checksum, containing your merchant ID and message checksum
  - A JSON-formatted body containing a valid Checkout object

The API will then return a JSON-formatted response body.

### URL

The base URL for the API is: [https://connect.icepay.com/api/v1/](https://connect.icepay.com/api/v1/)

The service and operation name follow on after the base URL. See [Available services and operations](#available-services-and-operations) for a list of available services, and Chapter 4 for a list of operations per service. A full API URL would have the following format: https://connect.icepay.com/api/v1/payment/checkout

This URL calls the Checkout operation under the Payment service.

### HTTP headers

To authenticate the message, two values are sent as HTTP headers.

The header MerchantID identifies the beneficiary of the payment.

The header Checksum verifies that the merchant mentioned in the header MerchantID is also the sender of the message. See Chapter 4 for an explanation of how this is done.

Header name | Description
----------- | -------------
Checksum    | Your calculated checksum which verifies you as the sender of the message. See 4.1 for the checksum calculation method.
MerchantID  | Your 5-digit MerchantID (not to be confused with the CompanyID) given to you when you registered with ICEPAY.

### Basic object structure

The basic JSON structure for every API call is formatted as below. Every message contains at least the field `Timestamp`. Every API operation has its own set of required or optional parameters.

```json
{
    "Timestamp": "2015-01-01 00:00:00",
    ...
}
```

Property  | Description
--------- | -------------
Timestamp | The date and time in UTC when your request was generated.

### Examples

The examples below show what a basic message exchange between the web shop and the ICEPAY REST API involves. The parameters per operation are listed under Chapter 5.

#### Request

A basic HTTP request to the REST API may look like this:

    POST /api/v1/payment/checkout/ HTTP/1.1
    MerchantID: 12345
    Checksum: 05b32c694c8b79bf77d6162df29364eb338de2038ac23b515826134dc311624e

```json
{
    "Timestamp": "2015-01-01T00:00:00",
    "Amount": "100",
    "Country": "NL",
    "Currency": "EUR",
    "Description": "Order from the webshop",
    "EndUserIP": "127.0.0.1",
    "PaymentMethod": "IDEAL",
    "Issuer": "ABNAMRO",
    "Language": "NL",
    "OrderID": "1000000123",
    "URLCompleted": "https://mywebshop.com/Payment/Success",
    "URLError": "https://mywebshop.com/Payment/Failure"
}
```

#### Response

The response to the above message is the following:

    MerchantID: 12345
    Checksum: b969a1fbb129fe623128b6b34b5a577af44a00b0e9d2ca322c2d5bdfaa0faf91

```json
{
    "Amount": 100,
    "Country": "NL",
    "Currency": "EUR",
    "Description": "Order from the webshop",
    "EndUserIP": "127.0.0.1",
    "Issuer": "ABNAMRO",
    "Language": "NL",
    "OrderID": "1000000123",
    "PaymentID": 123456789,
    "PaymentMethod": "IDEAL",
    "PaymentScreenURL": "https://link.to.bank/payment_page",
    "ProviderTransactionID": "",
    "Reference": "",
    "TestMode": false,
    "URLCompleted": "https://mywebshop.com/Payment/Success",
    "URLError": "https://mywebshop.com/Payment/Failure",
    "MerchantID": 12345,
    "Timestamp": "2015-01-01T00:00:00"
}
```

### Available services and operations

ICEPAY’s API operations are grouped under 2 services.

Service | Description
------- | -------------
Payment | All methods related to performing payments, retrieving active payment methods, retrieving payment information, etc.
Refund  | All refund operations.

### Continue documentation

Next chapter: [Checksum](checksum.md)
