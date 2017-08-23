<?php
namespace PapertrailForWP;
require_once 'papertrail-sender.php';
require_once 'papertrail-settings-validator.php';

class Papertrail_ErrorHandler {    
  
  public $papertrailSender;

  public function __construct(){
    $this->papertrailSender = new Papertrail_Sender;
  }

  public function error_handler(  $errno , $errstr, $errfile, $errline) {
    $message = "[ERROR] " .  $errstr . ' ' .  $errfile . ' ' . $errline;
    $this->send_message($message);
    return false;
  }

  public function exception_handler( $exception) {
    $message = "[ERROR] " . $exception->getMessage() . " " . $exception->getTraceAsString();
    $this->send_message($message);
    throw $exception;
  }

  public function send_message($message){
    $options = get_option( 'logging_with_papertrail_options' );

    $validator = new PapertrailSettingsValidator($options);

    if(!$validator->is_valid()){
      return;
    }

    $host =  esc_attr( $options['host']);
    $port =  esc_attr( $options['port']);
    $system =  esc_attr( $options['system']);
    $program =  esc_attr( $options['program']);
    $protocol =  esc_attr( $options['protocol']);

    $this->papertrailSender->send_remote_syslog($protocol, $message, $system , $program ,$host, $port);
}
  public function setup_handler(){
    set_error_handler( array( $this, 'error_handler'));
    set_exception_handler(array( $this, 'exception_handler'));
  }
}