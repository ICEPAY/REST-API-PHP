## CHANGELOG

Authors: See the [composer.json authors block](https://github.com/icepay/API/blob/master/composer.json) for all the authors and contributors of this project.

### 0.0.2 (18-04-2016)

Bugfixes:

  - Fixed vulnerability that made a man-in-the-middle attack possible.
  - Determine client IP from SERVER variables. The function 'getenv' does not work if your Server API is ASAPI (IIS).


### 0.0.1 (29-09-2015)

Features:

  - Initial public release for internal testing purposes.
  - GitHub markdown style documentation about the rest api.

Bugfixes:

  - Included intermediate certificates for curl error 60 or 77.
