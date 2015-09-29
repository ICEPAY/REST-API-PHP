## Checksum

The checksum is a digital signature that authenticates the sender of the message. This prevents others from sending payment requests in your name and prevents request tampering. It also assures you that any response or postback you receive actually originated from ICEPAY.

### How to calculate

The checksum calculation for the REST API differs greatly from that of the classic Advanced Mode and Web Service gateways. In the REST API, the full JSON body message is used to calculate the checksum. This ensures all fields in the request are safe from tampering. This checksum algorithm is used for all requests to and responses from the REST API, but not in postback messages.

  - Build up a base string consisting of the following data:
    - The full URL of the request
    - The HTTP verb (always POST) in uppercase
    - Your 5-digit merchant ID
    - Your 40-characer secret code
    - The full JSON-formatted body message, without formatting. This means no whitespace (spaces, tabs and newlines) between brackets and properties

    There should be no spaces or other characters inserted between the above data.
    
    Example:
    
    ```
    https://connect.icepay.com/api/v1/payment/checkout/POST12345AbCdEfGhIjKlMnOpQrStUvWxYz1234567890AbCd{"Timestamp":"2015-01-01T00:00:00"}
    ```
    
  - Ensure the base string is UTF-8 encoded
  
  - Calculate a SHA256 hash over the base string and format the output as hexadecimal. Note: use a regular SHA256 hash, not an HMAC.
    
    Example:
    
    ```
    4c8b79bf77d6162df3305b32c698de20c8b79b38ac23b515826134dc311624e29364eb
    ```

With these steps you should have a 64-character, hex encoded string. This will be the value of the Checksum header.

### Continue documentation

Next chapter: [Operation parameters](parameters.md)
