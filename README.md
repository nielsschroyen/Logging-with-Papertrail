# Papertrail-for-WordPress
[![Build Status](https://travis-ci.org/nielsschroyen/Papertrail-for-WordPress.svg?branch=master)](https://travis-ci.org/nielsschroyen/Papertrail-for-WordPress)
[![codecov](https://codecov.io/gh/nielsschroyen/Papertrail-for-WordPress/branch/master/graph/badge.svg)](https://codecov.io/gh/nielsschroyen/Papertrail-for-WordPress)

Contributors: nielsschroyen

Tags: papertrail, error logging, exception logging

Requires at least: 4.8.1

Tested up to: 4.8.1

Stable tag: 1.0

License: GPLv2


WordPress plugin to forward error messages to Papertrail.

## Description
Do you want to use **Papertrail** for **better monitoring** your websites? This plugin will enable you to send php-errors to Papertrail even if you do not have the knowledge, time or access to [install the proper Papertrail hooks](http://help.papertrailapp.com/kb/configuration/configuring-centralized-logging-from-php-apps/). You only need to install the plugin and enter your Papertrail information.
The plugin will automatically send all the php errors and exceptions happening within WordPress to papertrail.

### Notes
- Using this plugin will bypas the standard [PHP error handler](http://php.net/manual/en/function.set-error-handler.php) and [php exception handler](http://php.net/manual/en/function.set-exception-handler.php) within the script execution of WordPress. When the exception is posted to papertrail the exceptions are retrown.  

### Resources
[Creating admin option pages](https://codex.wordpress.org/Creating_Options_Pages)

[Papertrail Logging API](https://github.com/sc0ttkclark/papertrail)

[Troy's send_remote_syslog.php](https://gist.github.com/troy/2220679)

[Php's error handler](http://php.net/manual/en/function.set-error-handler.php)

[Plugin Handbook](https://developer.wordpress.org/plugins)

[Exception handling](https://stackoverflow.com/questions/5551668/what-are-the-best-practices-for-catching-and-re-throwing-exceptions)

[PHP code coverage](https://github.com/codecov/example-php)

## Installation
 1. Put the plugin in the plugins folder (`/wp-content/plugins/`)
 2. Activate plugin on the plugin page
 3. Enter your Papertrail information in the settings pages under the settings menu
 4. The system option allows you to change the system name within papertrail
 5. The program option allows you to differentiate within papertrail between diffent programs on one machine with the same name
 6. Choose between udp or tcp for your communication, use udp by default fallback to tcp if udp is not allowed on your environment

## Changelog
### 1.0.0
- Added: First release
- Added: Post errors to papertail
- Added: Post exceptions to papertrail
- Added: Admin settings page for saving papertrail information
- Added: Support custom system and program
- Added: Support udp and tcp(unenctrypted)
- Added: simple test settings on the admin page
