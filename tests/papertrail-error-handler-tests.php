<?php
use PHPUnit\Framework\TestCase;
require_once './php/papertrail-error-handler.php';
/*
https://stackoverflow.com/questions/29758674/how-do-you-unit-test-a-custom-exception-handler-in-php
*/
class PapertrailErrorHandlerTests extends TestCase
{
  public function test_OnException_Sender_IsCalled()
  {
    $errorHandler = new Papertrail_ErrorHandler();

    $fakeSender = $this->getMockBuilder('Papertrail_Sender')
                       ->getMock();

    $fakeSender->expects($this->exactly(1))
               ->method('send_remote_syslog')
               ->with($this->stringContains("[ERROR] test exception"), 'system', 'program', 'host', 'port');

    $errorHandler->papertrailSender = $fakeSender;

    try{
    $errorHandler->exception_handler(new Exception('test exception'));
    }catch(Exception $e){
      //Catch the retrown exception otherwise the test will fail
    }
  }

  public function test_OnException_Exception_IsReThrown()
  {
    $errorHandler = new Papertrail_ErrorHandler();
    $fakeSender = $this->getMockBuilder('Papertrail_Sender')->getMock();
    $errorHandler->papertrailSender = $fakeSender;

    $this->expectExceptionMessage('test exception');

    $errorHandler->exception_handler(new Exception('test exception'));
  }

  public function test_SetHandler_SetsExceptionHandler()
  {
    $errorHandler = new Papertrail_ErrorHandler();
    $errorHandler->setup_handler();
    
    $myExceptionHandler = set_exception_handler(null);

    $this->assertNotNull($myExceptionHandler);
  }
}
 function get_option() {
    return [
    "host" => "host",
    "port" => "port",
    "system" => "system",
    "program" => "program"
  ];
    }

function esc_attr($attr){
  return $attr;
}