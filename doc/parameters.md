## Operation parameters

This chapter lists all possible parameters per API operation. For a list of all allowed values, and value combinations, please consult the parameters sheet [available here](https://icepay.com/downloads/tech-docs/ICEPAY_Supported_Parameters_Sheet.pdf).

The parameters mentioned in this chapter form the JSON-formatted body of each request and response.

**Important notes:**

  - The field `issuer` must always contain a value allowed under the chosen payment method. For example when paying with iDEAL, the issuer must be a Dutch consumer bank supporting iDEAL. When paying with credit cards, the issuer must be a supported credit card scheme for which you have a subscription.
  - Most payment methods are limited to certain countries. Some payment methods (iDEAL, giropay, Carte Bleue etc.) are limited to one country, while others (Wire Transfer, SOFORT Banking) are limited to the SEPA area or to a certain part of the SEPA area. The Supported Parameters Sheet (see link above) specifies for the allowed countries for each payment method.

### Payment Service

#### Checkout

Request:

Member        | Description | Data type
------------- | ----------- | ---------
Timestamp     | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ | String
Amount        | This is the amount (in cents) that will be charged | Integer
Country       | This member will be interpreted differently depending on the chosen payment method. For phone and SMS payments, this will be the country in which the payment will take place. For all other payment methods, it is used to validate if the payment method is supported in a certain country. | Integer
Currency      | This is the currency. | String
Description   | A description of the payment. | String
EndUserIP     | IP address of the end-user. | String
Issuer        | This is the issuer of the payment method. | String
Language      | Language of the payment screen. | String
OrderID       | A unique code up to 10 characters. It is recommended to use the primary key field of your local transactions table. | String
PaymentMethod | This is the payment method that will be used for the transaction initialization. | String
Reference     | Custom information that you want to include, e.g. primary key of your local transactions table (up to 50 characters). | String
URLCompleted  | The URL to which the end-user will be redirected. If you do not set this member then the URLCompleted that you set in your ICEPAY account will be used. | String
URLError      | The URL to which the end-user will be redirected. If you do not set this member then the URLError that you set in your ICEPAY account will be used. | String

Response:

Member                | Description | Data type
--------------------- | ----------- | ---------
Timestamp             | This will be the current UTC time that has the following format: yyyy-mm-ddThh:mm:ssZ | String
Amount                | The requested amount in cents. | Integer
Country               | This is the requested country code. | String
Currency              | This is the requested currency. | String
Description           | This is the specified description. | String
EndUserIP             | This is the provided end-user IP. | String
Issuer                | This is the requested issuer. | String
Language              | This is the requested language code. | String
OrderID               | This is your provided Order ID. | String
PaymentID             | This is the generated ICEPAY transaction ID. Tip: if possible please store this in your local database as this ID may come in handy if you contact our support department. | Integer
PaymentMethod         | This is the requested Payment Method. | String
PaymentScreenURL      | This is the URL of the payment screen (if available). | String
ProviderTransactionID | This is the transaction ID of the issuer (if available). | String
Reference             | This is the specified reference information. | String
TestMode              | Indicates whether the transaction was initialized in test mode. This is true if your API key is still in test mode. To switch to production mode, please contact your account manager | Boolean
URLCompleted          | This is the page to which the end-user will be redirected to after a successful transaction. | String
URLError              | This is the page to which the end-user will be redirected to after a failed or cancelled transaction. | String

#### VaultCheckout

Request:

Member        | Description                                                                                                                                    | Data type
------------- | ---------------------------------------------------------------------------------------------------------------------------------------------- | ---------
PaymentMethod | Description of the payment method which will be used in the payment at the moment vaulting is supported for `credit card` and `iDEAL`.         | String
Amount        | The amount of the transaction.                                                                                                                 | Integer
Language      | The ISO code of the language e.g Dutch is `NL`                                                                                                  | String
Currency      | The ISO code of the currency e.g. Euro is `EUR`                                                                                                 | String
Country       | The ISO code of the country e.g. Netherlands is `NL`                                                                                            | String
Issuer        | The issuer connected to the payment method e.g. For credit card can be `VISA` or `MASTERCARD`                                                    | String
ConsumerID    | The ID which is wished to link to the consumer credit card or bank account to perform automatic checkouts. It can be alphanumeric.             | String
Timestamp     | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ                                                         | String
OrderID       | It is the Unique OrderID of the transaction.                                                                                                   | String
Description   | It is the description which appears along the payment in the ICEPAY`s environment.                                                              | String
EndUserIP     | Is the ip address of the customer                                                                                                              | String
URLCompleted  | This is the page to which the end-user will be redirected to after a successful transaction.                                                   | String
URLError      | Is the url where the user is redirected after erroneous payment.                                                                               | String
Reference     | Custom information that you want to include, e.g. primary key of your local transactions table (up to 50 characters). This field can be empty. | String

Response:

See the CheckoutResponse for the response.

#### AutomaticCheckout

Request:

Member        | Description                                                                                                                                                                                                                                                          | Data type
------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------
PaymentMethod | Can have two values: `ddebit` this is required to perform an automatic checkout prior to storing an iDEAL account number. `creditcard` this is required to perform an automatic checkout prior to storing a credit card number. The keywords are not case sensitive. | String
Amount        | Is the amount in cents which is desired to bill.                                                                                                                                                                                                                     | Integer
Language      | Is the language code of the billing e.g. for the Netherlands `NL`                                                                                                                                                                                                     | String
Currency      | Is the currency code e.g. for euro `EUR`                                                                                                                                                                                                                              | String
Country       | Is the country code e.g. for the Netherlands `NL`                                                                                                                                                                                                                     | String
Issuer        | This depends on the payment method insert before: For `creditcard` it must be `CCAUTOCHECKOUT`. For `ddebit` it must be `IDEALINCASSO`                                                                                                                               | String
ConsumerID    | This is the ConsumerID, which was vaulted previously using the VaultCheckout method.                                                                                                                                                                                 | String
Timestamp     | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ                                                                                                                                                                               | String
OrderID       | Is the OrderID corresponding to the transaction.                                                                                                                                                                                                                     | String
Description   | A compulsory description can be left empty                                                                                                                                                                                                                           | String
EndUserIP     | Is the IP address of the machine from which the action is performed.                                                                                                                                                                                                 | String
URLCompleted  | Is the URL where the user lands upon a successful transaction.                                                                                                                                                                                                       | String
Reference     | Can be an additional remark, may be left empty.                                                                                                                                                                                                                      | String

Response:

Member  | Description                                                      | Data type
------- | ---------------------------------------------------------------- | ---------
Success | Indicates whether the operation had been successfully completed. | Boolean

#### GetPayment

Request:

Member    | Description                                                                                            | Data type
--------- | ------------------------------------------------------------------------------------------------------ | ---------
Timestamp | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ                 | String
PaymentID | This is the ICEPAY PaymentID. You will receive this when you initialize a payment or in your Postback. | Integer

Response:

Member                | Description                                                                                              | Data type
--------------------- | -------------------------------------------------------------------------------------------------------- | ---------
Timestamp             | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ                   | String
PaymentID             | This is the ICEPAY PaymentID.                                                                            | Integer
Amount                | The requested amount of the payment.                                                                     | Integer
Currency              | The requested currency of the payment.                                                                   | Integer
Description           | The description specified by the merchant during the initialization.                                     | String 
Duration              | The numbers of seconds dialed. Only applicable for phone payments.                                       | Integer
ConsumerName          | Name of the consumer (if available).                                                                     | String
ConsumerAccountNumber | Partial account number of the consumer (if available).                                                   | String
ConsumerAddress       | Address of the consumer (if available).                                                                  | String
ConsumerHouseNumber   | House number of the address of the consumer (if available).                                              | String
ConsumerCity          | City of the consumer (if available).                                                                     | String
ConsumerCountry       | Country of the consumer (if available).                                                                  | String
ConsumerEmail         | E-mail address of the consumer (if available).                                                           | String
ConsumerPhoneNumber   | Phone number of the consumer (if available).                                                             | String
ConsumerIPAddress     | IP address of the consumer (if available)                                                                | String
Issuer                | Requested payment method issuer                                                                          | String
OrderID               | The OrderID specified by the merchant during the initialization                                          | String
OrderTime             | The time when the payment got started. In GMT.                                                           | String
PaymentMethod         | The requested payment method                                                                             | String
PaymentTime           | The time indicating when the payment got closed/completed (either successful or not successful). In GMT. | String
Reference             | The reference specified by the merchant during the initialization.                                       | String
Status                | The status of the payment (please see 5.1.1 for possible statuses).                                      | String
StatusCode            | A description giving you more information on the status.                                                 | String
TestMode              | Indicates whether the payment was created when the API key was still in test mode.                       | Boolean

#### GetMyPaymentMethods

Request:

Member    | Description                                                                            | Data type
--------- | -------------------------------------------------------------------------------------- | ---------
Timestamp | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ | String

Response:

Member         | Description                                                               | Data type
-------------- | ------------------------------------------------------------------------- | ---------
PaymentMethods | A list of PaymentMethod objects describing all available payment methods. | Array

Paymentmethods object:

Member            | Description                                                                                                       | Data type
----------------- | ----------------------------------------------------------------------------------------------------------------- | ----------------
PaymentMethodCode | Text identifier of the payment method. This is the input for the PaymentMethod parameter of the Checkout methods. | String
Description       | Description of the payment method.                                                                                | String
Issuers           | Contains all available issuers for the payment method.                                                            | Array of Issuers

Issuers object:

Member        | Description                                                                                        | Data type
------------- | -------------------------------------------------------------------------------------------------- | ------------------
IssuerKeyword | Text identifier of the issuer. This is the input for the Issuer parameter of the Checkout methods. | String
Description   | Description of the issuer.                                                                         | String
Countries     | Contains all available countries for the issuer.                                                   | Array of Countries

Countries object:

Member        | Description                                                                                          | Data type
------------- | ---------------------------------------------------------------------------------------------------- | ---------
CountryCode   | Text identifier of the country. This is the input for the Country parameter of the Checkout methods. | String
Currency      | 3-letter code for the applicable currency in the country.                                            | String
MinimumAmount | The minimum payment amount required for this combination of payment method, issuer and country.      | Integer
MaximumAmount | The maximum payment amount allowed for this combination of payment method, issuer and country.       | Integer

### Refund Service

#### RequestRefund

Request:

Member         | Description                                                                                             | Data type
-------------- | ------------------------------------------------------------------------------------------------------- | ---------
Timestamp      | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ                  | String
PaymentID      | The ID of the payment.                                                                                  | Integer
RefundAmount   | The amount to be refunded (in cents).                                                                   | Integer
RefundCurrency | The currency of the refund. Remark: This currency must match the currency of the payment.               | String

Response:

Member                | Description                                                                                                                                                                   | Data type
--------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------
Timestamp             | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ                                                                                        | String
RefundID              | This is the ID of the requested refund. If possible, it is recommended to store this value in your system as you may decide (at a later stage), to cancel the refund request. | Integer
PaymentID             | This is the payment for which you requested a refund.                                                                                                                         | Integer
RefundAmount          | The requested refund amount specified in the request.                                                                                                                         | Integer
RemainingRefundAmount | The remaining amount that you can still request a refund for.                                                                                                                 | Integer
RefundCurrency        | The requested refund currency specified in the request.                                                                                                                       | String

#### CancelRefund

Request:

Member    | Description                                                                                         | Data type
--------- | --------------------------------------------------------------------------------------------------- | ---------
Timestamp | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ              | String
RefundID  | This is the RefundID that is returned by the RequestRefund web method upon a successful invocation. | Integer
PaymentID | This is the PaymentID of the transaction, which you requested a refund for initially.               | Integer

Response:

Member    | Description                                                                             | Data type
--------- | --------------------------------------------------------------------------------------- | ---------
Timestamp | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ  | String
Success   | This field will contain the value `Y` if the refund request was cancelled successfully. | String

#### GetPaymentRefunds

Request:

Member    | Description                                                                            | Data type
--------- | -------------------------------------------------------------------------------------- | ---------
Timestamp | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ | String
PaymentID | This is the PaymentID of the transaction for which you requested the refund initially. | Integer

Response:

Member    | Description                                                                                                              | Data type
--------- | ------------------------------------------------------------------------------------------------------------------------ | ---------------
Timestamp | This is the current UTC time that must have the following format: yyyy-mm-ddThh:mm:ssZ                                   | String
Refunds   | A collection of Refund objects. If you have done several partial refunds, then this collection contains several objects. | Array of Refund

Refunds object:

Member         | Description                                                                                                                                                                                                                                                        | Data type
-------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ---------
RefundID       | This is a unique ID that is assigned to your refund request.                                                                                                                                                                                                       | Integer
RefundAmount   | This is the amount of the refund.                                                                                                                                                                                                                                  | Integer
RefundCurrency | This is the currency of the refund.                                                                                                                                                                                                                                | String
DateCreated    | This value indicates when the refund request was created (in UTC+0): yyyy-mm-ddThh:mm:ssZ                                                                                                                                                                          | String
Status         | A refund can have one of the following status:<br><br>`PENDING`: Refund is placed in the queue<br>`PROCESSING`: Refund sent to financial institution for refund<br>`COMPLETED`: Refund processed by financial institution<br>`REFUSED`: Refund cannot be processed | String

### Continue documentation

Next chapter: [Examples](examples.md)
