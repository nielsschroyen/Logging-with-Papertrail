# Papertrail-for-WordPress
WordPress plugin to forward error messages to Papertrail.

Do you want to use **Papertrail** for **better monitoring** your websites? This plugin will enable you to send php-errors to Papertrail even if you do not have the knowledge, time or access to [install the proper Papertrail hooks](http://help.papertrailapp.com/kb/configuration/configuring-centralized-logging-from-php-apps/). You only need to install the plugin and enter your Papertrail information.

##Setup
 1. Install plugin
 2. Enter your Papertrail information in the settings pages

**Done!**

##Notes
- Using this plugin will [bypas the standard PHP error handler](http://php.net/manual/en/function.set-error-handler.php) within the script execution of WordPress.  
- The plugin uses [sockets](http://www.php.net/manual/en/sockets.installation.php) to   communicate with Papertrail. The extention should be enabled by
   default.

##Resources
[Creating admin option pages](https://codex.wordpress.org/Creating_Options_Pages)
[Papertrail Logging API](https://github.com/sc0ttkclark/papertrail)