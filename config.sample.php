<?php

/**
 * Configurations for your NOC Grid
 */

//Optional error display for debugging (set to false for production)
ini_set( "display_errors", false);

//Name of the dashboard instance
define("DASHBOARD_LOCATION_NAME", "NOC Grid");

//The URL path for the dashboard instance
define("URL_PATH", $_SERVER['REQUEST_URI']);

//The host address of the NetBeez API (this is usually your NB dashboard's hostname)
define("API_HOST", "https://<YOUR_NETBEEZ_SERVER_HOSTNAME>");

//The NetBeez API version
define("API_VERSION", "v1");

//Your authentication key for accessing the API
define("API_AUTH_KEY", "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");

//Boolean setting for cURL option to verify the SSL host
define("SSL_VERIFY_HOST", true);

//Boolean setting for cURL option to verify the SSL peer.
//Default is false due to issue with certificate configuration on internal NetBeez instances
define("SSL_VERIFY_PEER", false);

//Boolean setting to enable or disable the alternate dark theme
define("DARK_THEME_ENABLED", false);