<?php

require_once 'papertrail-sender.php';

class Papertrail_ErrorHandler {    

    public static function error_handler(  $errno , $errstr, $errfile, $errline) {
        $message = "[ERROR] " .  $errstr . ' ' .  $errfile . ' ' . $errline;
        Papertrail_ErrorHandler::send_message($message);
        return false;
	}

     public static function exception_handler( $exception) {
        $message = "[ERROR] " . $exception->getMessage() . " " . $exception->getTraceAsString();
        Papertrail_ErrorHandler::send_message($message);
        throw $exception;
    }

    public static function send_message($message){
        $options = get_option( 'papertrail_for_wordpress_options' );
        $host =  esc_attr( $options['host']);
        $port =  esc_attr( $options['port']);
        Papertrail_Sender::send_remote_syslog( $message, "WordPresso", "Dev-Machine",$host, $port);
	}

    public static function setup_handler(){
        set_error_handler( array( 'Papertrail_ErrorHandler', 'error_handler'));
        set_exception_handler(array( 'Papertrail_ErrorHandler', 'exception_handler'));
    }
}