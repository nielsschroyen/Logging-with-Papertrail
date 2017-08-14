 <?php
/**
 * Plugin Name: Papertrail for WordPress
 * Plugin URI: https://github.com/nielsschroyen/Papertrail-for-WordPress
 * Description: Write php errors to Papertrail
 * Version: 1.0.0
 * Author: Niels Schroyen
 * Author URI: https://www.linkedin.com/in/niels-schroyen-4721b241/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

require_once 'php/papertrail-error-handler.php';
require_once 'php/papertrail-admin-page.php';

$errorHandler =  new Papertrail_ErrorHandler;
$errorHandler->setup_handler();