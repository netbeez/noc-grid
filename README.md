# NOC Grid

Welcome to the NOC Grid! The NOC Grid is a configurable single-page dashboard that displays test statuses of NetBeez Agents and Targets in a grid.  The grid provides a high level overview of your network and resources, making in a handy addition to your NOC setup.  It uses the NetBeez API to obtain data.

## Features

* Easy to install and configure
* Complete control over which Agents and Targets are displayed
* Automatic sorting separates Agents and Targets by status, making it easy to spot outages and issues
* Alternate dark theme 

## Requirements

* An operational NetBeez instance (If you don't have one, please inquire at [https://resources.netbeez.net/get-started/schedule-a-demo](https://resources.netbeez.net/get-started/schedule-a-demo))
* PHP 5.6 and Apache 2.4.7
* cURL Library enabled

## Installation Instructions

1. Make sure PHP and Apache are running on your server and that the cURL library extension for PHP is enabled.
2. Download and unzip the noc-grid repository.
3. Go to your NetBeez instance, open Settings > API Keys and generate a new API key (if you have not done so already). [Here's more info on API keys](https://netbeez.zendesk.com/hc/en-us/articles/217532786-Settings-API-Keys).
4. Copy `config.sample.php` to `config.php`.
5. Open `config.php` and enter your information:
  * Give your NOC Grid a title:
  ```php
//Name of the dashboard instance
define("DASHBOARD_LOCATION_NAME", "NOC Grid");
```
  * Input your NetBeez hostname and API key, overwriting the placeholder values:
  ```php
//The host address of the NetBeez API (this is usually your NB dashboard's hostname)
define("API_HOST", "https://<YOUR_NETBEEZ_SERVER_HOSTNAME>");

//The NetBeez API version
define("API_VERSION", "v1");

//Your authentication key for accessing the API
define("API_AUTH_KEY", "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
```
Note: At this point in time, your API version is always going to be v1, so don’t worry about this option.
  * (_Optional_) Turn on the dark theme:
  ```php
//Boolean setting to enable or disable the alternate dark theme
define("DARK_THEME_ENABLED", false);
```

6. Upload the noc-grid files to the desired directory on your server/webhost.
7. Visit your new (empty) NOC Grid dashboard

#### Installation Notes

In the config file, you’ll see two additional options:

```php
//Boolean setting for cURL option to verify the SSL host
define("SSL_VERIFY_HOST", true);

//Boolean setting for cURL option to verify the SSL peer.
//Default is false due to issue with certificate configuration on internal NetBeez instances
define("SSL_VERIFY_PEER", false);
```
If you encounter cURL certificate errors, you may need to have both of these options set to false.  This is a certificate issue in internally hosted NetBeez instances that prevents access to the API endpoint data. If your server/certificate configuration allows, we recommend setting `SSL_VERIFY_PEER` to true, as this is more secure.

## Setting Up The Grid

You will find that your newly installed NOC Grid is empty.  This is because no Agents or Targets have been selected.  The NOC Grid comes with an easy-to-use GUI for selecting which Agents and Targets will appear in the grid.  This saves you from having to make changes to the files directly, and makes it easy to deploy multiple instances of the NOC Grid that show different selections of Agents and Targets.

1. Visit your NOC Grid in your browser and navigate to `/admin`.  This will take you to the Admin Settings.
2. Select the Agents and Targets that you would like to have displayed in the grid.
3. Optionally, you can set any Agent or Target to Maintenance Mode.  This feature can be used to mark Agents/Targets with known issues to mitigate false positives.
4. Optionally, you can change the refresh interval.  This determines how often the NOC Grid refreshes and gets new data from the API.  Default is 2 minutes.
5. Click Save.
6. Navigate back the main NOC Grid page and refresh (or wait for it to refresh on its own).

#### Note on Securing Admin Settings

Because the NOC Grid is a lightweight widget designed for internal use, there is no built-in password protection or other security for the Admin Settings at this time.  You can password protect this page with .htaccess.

We might introduce some basic built-in password protection down the line, but no promises.

## Fork and Customize

Interested in adding your own branding or changing the look and feel?  Want to see the grid sort differently?  Feel free to fork and customize NOC Grid to meet your needs.

## Contributors

[Allison Jones](https://github.com/alambertj)

## License

The NetBeez Network Status Dashboard is available under the Apache License
  