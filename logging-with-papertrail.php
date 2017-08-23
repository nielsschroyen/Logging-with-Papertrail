<?php
/**
 * Plugin Name: Logging with Papertrail
 * Plugin URI: https://github.com/nielsschroyen/Logging-with-Papertrail
 * Description: Write php errors and exceptions to Papertrail
 * Version: 1.0.0
 * Author: nielsschroyen
 * Author URI: https://www.linkedin.com/in/niels-schroyen-4721b241/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

require_once 'php/papertrail-error-handler.php';
require_once 'php/papertrail-admin-page.php';

$errorHandler =  new PapertrailForWP\Papertrail_ErrorHandler;
$errorHandler->setup_handler();

PapertrailForWP\PapertrailAdminPage::init_admin_page();