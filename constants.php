<?php
/****************************************************
constants.php

This is the configuration file for the samples.This file
defines the parameters needed to make an API call.

PayPal includes the following API Signature for making API
calls to the PayPal sandbox:

API Username 	sdk-three_api1.sdk.com
API Password 	QFZCWN5HZM8VBG7Q
API Signature 	A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI

Called by CallerService.php.
****************************************************/
/**
# API user: The user that is identified as making the call. you can
# also use your own API username that you created on PayPal’s sandbox
# or the PayPal live site
*/

if(true || strpos($_SERVER['HTTP_HOST'], 'stage.') === false) {
	define('API_USERNAME', 'Mike_Sobolev_api1.yahoo.com');
	define('API_PASSWORD', 'P3VK8QUJRYEUSLMP');
	define('API_SIGNATURE', 'AUq-T468VCe2HZHMReG06VnsJR.nAS1gxRJCb0k9SnxT1-dzyBI7c-vJ');
	define('API_ENDPOINT', 'https://api-3t.paypal.com/nvp');
} else {
	define('API_USERNAME', 'misha.sobolev_api1.gmail.com');
	define('API_PASSWORD', 'Z2TAKAE7PUEGB9W3');
	define('API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31ATHPEgf1m25TINYAbKoSyOQESd58');
	define('API_ENDPOINT', 'https://api-3t.sandbox.paypal.com/nvp');
}

/*
 # Third party Email address that you granted permission to make api call.
 */
define('SUBJECT','');

/**
USE_PROXY: Set this variable to TRUE to route all the API requests through proxy.
like define('USE_PROXY',TRUE);
*/
define('USE_PROXY',FALSE);
/**
PROXY_HOST: Set the host name or the IP address of proxy server.
PROXY_PORT: Set proxy port.

PROXY_HOST and PROXY_PORT will be read only if USE_PROXY is set to TRUE
*/
define('PROXY_HOST', '127.0.0.1');
define('PROXY_PORT', '808');

/* Define the PayPal URL. This is the URL that the buyer is
   first sent to to authorize payment with their paypal account
   change the URL depending if you are testing on the sandbox
   or going to the live PayPal site
   For the sandbox, the URL is
   https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=
   For the live site, the URL is
   https://www.paypal.com/webscr&cmd=_express-checkout&token=
   */
define('PAYPAL_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=');


/**
# Version: this is the API version in the request.
# It is a mandatory parameter for each API request.
# The only supported value at this time is 2.3
*/

define('VERSION', '61.0');

// Ack related constants
define('ACK_SUCCESS', 'SUCCESS');
define('ACK_SUCCESS_WITH_WARNING', 'SUCCESSWITHWARNING');

?>
