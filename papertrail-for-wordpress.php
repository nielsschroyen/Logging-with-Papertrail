 <?php
/**
 * Plugin Name: Papertrail for WordPress
 * Plugin URI: https://github.com/nielsschroyen/Papertrail-for-WordPress
 * Description: Write php errors to papertrail
 * Version: 1.0.0
 * Author: Niels Schroyen
 * Author URI: https://www.linkedin.com/in/niels-schroyen-4721b241/
 * License: MIT
 */

require_once 'php/papertrail-error-handler.php';

Papertrail_ErrorHandler::setup_handler();