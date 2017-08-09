<?php

require_once 'papertrail-sender.php';

class Papertrail_ErrorHandler {    


    public static function error_handler(  $errno , $errstr, $errfile, $errline) {
        $options = get_option( 'papertrail_for_wordpress_options' );
        $host =  esc_attr( $options['host']);
        $port =  esc_attr( $options['port']);
        
        $message = "[ERROR] " .  $errstr . ' ' .  $errfile . ' ' . $errline;
        Papertrail_Sender::send_remote_syslog( $message, "WordPresso", "Dev-Machine",$host, $port);

        return false;
	}

    public static function setup_handler(){
        set_error_handler( array( 'Papertrail_ErrorHandler', 'error_handler'));
    }
}