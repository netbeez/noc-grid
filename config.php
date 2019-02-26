<?php
/**
 * Created by PhpStorm.
 * User: Allison
 * Date: 6/11/2018
 * Time: 9:16 AM
 */

//Optional error display for debugging (set to false for production)
ini_set( "display_errors", false);

//Name of the dashboard instance location
define("DASHBOARD_LOCATION_NAME", "Your Location");

//Enter the root URL path for the dashboard instance
//define("ABS_PATH", "/");
define("ABS_PATH", "http://localhost:8888/noc-grid-project/noc-grid");


//The host address of the NetBeez API (this is usually your NB dashboard's hostname)
//define("API_HOST", "<YOUR_NETBEEZ_HOSTNAME>");
define("API_HOST", "https://205.219.230.11");
//define("API_HOST", "https://demo.netbeezcloud.net");

//The NetBeez API version
define("API_VERSION", "v1");

//Your authentication key for accessing the API
//define("API_AUTH_KEY", "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
define("API_AUTH_KEY", "04f97e7e03329391bc2ff294b1759be721bd24e4");
//define("API_AUTH_KEY", "680a3d759573306f4bd09e88999c348ea42ae60c");

//Boolean setting for cURL option to verify the SSL host
define("SSL_VERIFY_HOST", false);

//Boolean setting for cURL option to verify the SSL peer.
//Default is false due to issue with certificate configuration on internal NetBeez instances
define("SSL_VERIFY_PEER", false);

//Boolean setting to enable or disable the alternate dark theme
define("DARK_THEME_ENABLED", true);