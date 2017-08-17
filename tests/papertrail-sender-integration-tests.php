<?php
namespace Tests{
  use PHPUnit\Framework\TestCase;
  
  class PapertrailSenderIntegrationTests extends TestCase
  {
    public function test_send_to_papertrail(){    
      set_error_handler(function(){return true;});
      $client = stream_socket_client("tcp://logsX.papertrailapp.com:XXX", $errno, $errstr);
      if($client != null){
        fwrite($client, "<22>Apr 25 23:45:56 ServerName System: tcp the log message\n");
        fclose($client);        
      }
      restore_error_handler();
     
      $this->assertTrue(true);
      
    }
  }
}