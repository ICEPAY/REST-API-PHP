## Error messages

Here is a list of response error messages and the description of the error.

### General messages

Error code | Description
---------- | -----------
ERR_0000   | Internal server error: XXX An unexpected error occurred. Please contact support@icepay.eu with the full merchant web shop database log to resolve.
ERR_0001   | Request is missing You did not provide a request object with the web method.
ERR_0002   | Please provide a valid 'MerchantID' member You must provide a valid numeric 'MerchantID' member.
ERR_0003   | Please provide the 'XXX' member You forgot to include a member in your web method request object. Where XXX is the name of the member that you forgot to include.
ERR_0004   | Please provide the IP address of your end-user You forgot to include the IP address of the end-user.
ERR_0005   | Merchant 'XXXXX' is disabled Your API key is disabled. Please contact your account manager regarding this issue.
ERR_0006   | Merchant 'XXXXX' was not found Unknown MerchantID
ERR_0007   | Checksum for 'XXX' is invalid The provided checksum did not match. Where XXX is the name of the web method for which the checksum failed. Please make sure the hash of the checksum is in lower case.
ERR_0008   | You can only invoke this method using the 'XXX' payment method This exception means that the web method can only be used in conjunction with the XXX payment method.
ERR_0009   | Payment with ID 'XXX' not found
ERR_0010   | 'XXX' parameter must be at least YY characters The length of the provided parameter must be at least YY characters long.
ERR_0011   | 'XXX' parameter may not exceed YY characters The length of the parameter has exceeded the maximum allowed length YY.
ERR_0012   | 'XXX' is an invalid payment method
ERR_0013   | Invalid date: X The provided date is in an invalid format. Please provide a string in the following format: YYYY-MM-DD or YYYY-MM-DD HH:MM
ERR_0014   | Invalid date period Please provide a valid month and year combination.
ERR_0015   | The provided country code ‘XX’ is invalid
ERR_0016   | Payment does not belong to specified merchant You (accidently) specified a PaymentID that does not belong to the specified merchant.

### Refund service messages

Error code | Description
---------- | -----------
ERR_2000   | Merchant not granted to use Refund Web Service The merchant is not granted access to use the Refund Web Service. In order to enable the Refund Web Service for your merchant, please log into your ICEPAY account to configure your merchants.
ERR_2001   | Invalid RefundID 'XXX' The RefundID that you provided is invalid. Please check the RefundID.
ERR_2002   | Amount to refund exceeds remaining balance You were trying to initiate a refund request with an amount that is larger than the requested amount.
ERR_2003   | Payment method is not supported by the Refund Web Service The payment method used for the provided payment does not support refund possibilities.
ERR_2004   | Invalid RefundAmount Please make sure that: * The amount is in cents * The amount is positive
ERR_2005   | Refund currency does not match payment currency
ERR_2006   | You can only refund payments with the status 'OK'
ERR_2007   | RefundID does not belong to PaymentID
