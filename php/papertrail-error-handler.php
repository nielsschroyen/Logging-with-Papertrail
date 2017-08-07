<?php

require_once 'papertrail-sender.php';

class Papertrail_ErrorHandler {    
    public static function error_handler(  $errno , $errstr, $errfile, $errline, $errcontext) {
        $message = "[ERROR] " .  $errstr . ' ' .  $errfile . ' ' . $errline;
        Papertrail_Sender::send_remote_syslog( $message, "WordPress", "Dev-Machine", 'URL FOR PAPERTRAIL', 'PORT FOR PAPERTRAIL');
	}

    public static function setup_handler(){
        set_error_handler( array( 'Papertrail_ErrorHandler', 'error_handler'));
    }
}