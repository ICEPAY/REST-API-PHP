## ICEPAY REST API for PHP

This REST API Implementation documentation is for the reference of developers wanting to make a custom implementation using the REST API gateway.

### Glossary

Term      | Definition
--------  | -------------
Merchant  | Direct client of ICEPAY. A company that operates the website connected to the ICEPAY transaction platform. Also referred to as Client.
Consumer  | The customer of the Merchant. The end-user who makes a payment through the website/webshop of the Merchant. Also referred to as Customer.

### Integration with ICEPAY

ICEPAY offers several gateways for merchants to connect through, including a SOAP Web Service and a REST API. Both these gateways offer seamless integration with your webshop, meaning that your end customers will not see any user interface at ICEPAY. The whole payment process can take place entirely in the webshop.

> An exception to this is credit card, since PCI regulation puts heavy requirements on merchants who offer credit card number inputs directly in their webshop.

Today the most popular method of web service integration is using JSON message structure over a RESTful API. RESTful architecture has the following properties:

  - Compatibility with various programming languages and frameworks
  - A considerably shorter implementation time

### Webshop Modules

For merchants using well known webshop software (e.g. Magento, OSCommerce, WooCommerce), ICEPAY offers ready-to-install [payment modules](https://icepay.com/nl/en/webshop-modules/).

### Continue documentation

Next chapter: [Starting your implementation](start.md)
