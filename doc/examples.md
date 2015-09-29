## Examples

As a start we've made some examples to use the ICEPAY REST API client. It is important to know that the information in these examples are fictitious. You will need to adjust them before usage.

### Checkout

Here we use `iDEAL` as payment method with the issuer `ABN AMRO` to create a payment of EUR 10.00.
For a list of all allowed values, and value combinations on payment methods and issuers, please consult the parameters sheet [available here](https://icepay.com/downloads/tech-docs/ICEPAY_Supported_Parameters_Sheet.pdf).

```php
<?php

// Load all the dependencies through Composer
require_once('vendor/autoload.php');

// Or through the legacy Autoloader
// require_once('src/Icepay/API/Autoloader.php');

// Initiate the client
$icepay = new Icepay\API\Client();

// Configuration settings
$icepay->setApiKey('xxxxx');
$icepay->setApiSecret('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$icepay->setCompletedURL('http://example.com/payment.php');
$icepay->setErrorURL('http://example.com/payment.php');

$payment = $icepay->payment->checkOut(array(
    'Amount'        => 1000,
    'Currency'      => 'EUR',
    'Paymentmethod' => 'IDEAL',
    'Issuer'        => 'ABNAMRO',
    'Country'       => 'NL',
    'Language'      => 'NL',
    'Description'   => 'This is a example description',
    'OrderID'       => '1',
    'Reference'     => '1'
));

print_r($payment);
```

This example will print out the whole Checkout response. You should better redirect a customer directly to the payment screen by getting the `PaymentScreenURL` string and redirect the customer to that string.
See the [Checkout Response](https://github.com/icepay/API/blob/master/doc/parameters.md#checkout) for more information.

### VaultCheckout

In this example we start a recurring payment. After this payment has been successful, in the future, use AutomaticCheckout to continue using the recurring payment.
Again, we use `iDEAL` as payment method with the issuer `ABN AMRO` to create a recurring payment.

For a list of all allowed values, and value combinations on payment methods and issuers, please consult the parameters sheet [available here](https://icepay.com/downloads/tech-docs/ICEPAY_Supported_Parameters_Sheet.pdf).

```php
<?php

// Load all the dependencies through Composer
require_once('vendor/autoload.php');

// Or through the legacy Autoloader
// require_once('src/Icepay/API/Autoloader.php');

// Initiate the client
$icepay = new Icepay\API\Client();

// Configuration settings
$icepay->setApiKey('xxxxx');
$icepay->setApiSecret('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$icepay->setCompletedURL('http://example.com/payment.php');
$icepay->setErrorURL('http://example.com/payment.php');

$recurring = $icepay->payment->vaultCheckout(array(
    'Amount'        => 1000,
    'Currency'      => 'EUR',
    'Paymentmethod' => 'IDEAL',
    'Issuer'        => 'ABNAMRO',
    'Country'       => 'NL',
    'Language'      => 'NL',
    'Description'   => 'Recurring subscription',
    'OrderID'       => '1',
    'Reference'     => '1',
    'CustomerID'    => '1001'
));

print_r($recurring);
```

This example will print out the whole VaultCheckout object response. You could better redirect a customer directly to the payment screen by getting the `PaymentScreenURL` string and redirect the customer to that string.
See the [Checkout Response](https://github.com/icepay/API/blob/master/doc/parameters.md#checkout) for more information.

### AutomaticCheckout

In this example we want to get paid again for the recurring payment we did in vaultCheckout.
For a list of all allowed values, and value combinations on payment methods and issuers, please consult the parameters sheet [available here](https://icepay.com/downloads/tech-docs/ICEPAY_Supported_Parameters_Sheet.pdf).

```php
<?php

// Load all the dependencies through Composer
require_once('vendor/autoload.php');

// Or through the legacy Autoloader
// require_once('src/Icepay/API/Autoloader.php');

// Initiate the client
$icepay = new Icepay\API\Client();

// Configuration settings
$icepay->setApiKey('xxxxx');
$icepay->setApiSecret('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$icepay->setCompletedURL('http://example.com/payment.php');
$icepay->setErrorURL('http://example.com/payment.php');

$continue_recurring = $icepay->payment->autoCheckout(array(
    'Amount'        => 1000,
    'Currency'      => 'EUR',
    'Paymentmethod' => 'DDEBIT',
    'Issuer'        => 'IDEALINCASSO',
    'Country'       => 'NL',
    'Language'      => 'NL',
    'Description'   => 'This is a example description',
    'OrderID'       => '1',
    'Reference'     => '1',
    'CustomerID'    => '1001'
));

print_r($continue_recurring);
```

This example will return a success with a boolean witch is either `True` or `False`.

**NOTE:** The string `ConsumerID` which was vaulted previously by using the VaultCheckout is used to let the payment reoccur without using the VaultCheckout to create a new payment.

### GetPayment

Here we request our API service to display all the information about a payment:

```php
<?php

// Load all the dependencies through Composer
require_once('vendor/autoload.php');

// Or through the legacy Autoloader
// require_once('src/Icepay/API/Autoloader.php');

// Initiate the client
$icepay = new Icepay\API\Client();

// Configuration settings
$icepay->setApiKey('xxxxx');
$icepay->setApiSecret('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$icepay->setCompletedURL('http://example.com/payment.php');
$icepay->setErrorURL('http://example.com/payment.php');

$getpayment = $icepay->payment->getPayment(array(
    'PaymentID' => 10000000
));

print_r($getpayment);
```

See the [GetPayment Response](https://github.com/icepay/API/blob/master/doc/parameters.md#getpayment) for more information.

### GetMyPaymentMethods

Here we request the API service to return all the active payment methods for the merchant.

```php
<?php

// Load all the dependencies through Composer
require_once('vendor/autoload.php');

// Or through the legacy Autoloader
// require_once('src/Icepay/API/Autoloader.php');

// Initiate the client
$icepay = new Icepay\API\Client();

// Configuration settings
$icepay->setApiKey('xxxxx');
$icepay->setApiSecret('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$icepay->setCompletedURL('http://example.com/payment.php');
$icepay->setErrorURL('http://example.com/payment.php');

print_r($icepay->payment->getMyPaymentMethods());
```

See the [GetMyPaymentMethods Response](https://github.com/icepay/API/blob/master/doc/parameters.md#getmypaymentmethods) for more information.

### RequestRefund

Here we want to refund a payment that was made on our merchant id.

```php
<?php

// Load all the dependencies through Composer
require_once('vendor/autoload.php');

// Or through the legacy Autoloader
// require_once('src/Icepay/API/Autoloader.php');

// Initiate the client
$icepay = new Icepay\API\Client();

// Configuration settings
$icepay->setApiKey('xxxxx');
$icepay->setApiSecret('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$icepay->setCompletedURL('http://example.com/payment.php');
$icepay->setErrorURL('http://example.com/payment.php');

$refund = $icepay->refund->startRefund(array(
    'Amount'    => 1000,
    'PaymentID' => 10000000,
    'Currency'  => 'EUR'
));

print_r($refund);
```

See the [RequestRefund Response](https://github.com/icepay/API/blob/master/doc/parameters.md#requestrefund) for more information.

### CancelRefund

Here we want to cancel a refund

```php
<?php

// Load all the dependencies through Composer
require_once('vendor/autoload.php');

// Or through the legacy Autoloader
// require_once('src/Icepay/API/Autoloader.php');

// Initiate the client
$icepay = new Icepay\API\Client();

// Configuration settings
$icepay->setApiKey('xxxxx');
$icepay->setApiSecret('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$icepay->setCompletedURL('http://example.com/payment.php');
$icepay->setErrorURL('http://example.com/payment.php');

$refund = $icepay->refund->cancelRefund(array(
    'RefundID'  => 100025300,
    'PaymentID' => 100212300
));

print_r($refund);
```

See the [CancelRefund Response](https://github.com/icepay/API/blob/master/doc/parameters.md#cancelrefund) for more information.

### GetPaymentRefunds


```php
<?php

// Load all the dependencies through Composer
require_once('vendor/autoload.php');

// Or through the legacy Autoloader
// require_once('src/Icepay/API/Autoloader.php');

// Initiate the client
$icepay = new Icepay\API\Client();

// Configuration settings
$icepay->setApiKey('xxxxx');
$icepay->setApiSecret('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$icepay->setCompletedURL('http://example.com/payment.php');
$icepay->setErrorURL('http://example.com/payment.php');

$refundinformation = $icepay->refund->getRefundStatus(array(
    'PaymentID' => 10581715
));

print_r($refundinformation);
```

See the [GetPaymentRefunds Response](https://github.com/icepay/API/blob/master/doc/parameters.md#getpaymentrefunds) for more information.

### Continue documentation

Next chapter: [Error messages](errors.md)
