<?php
namespace Tests{

  require_once './php/papertrail-error-handler.php';
  use PHPUnit\Framework\TestCase;
  use PapertrailForWP\Papertrail_ErrorHandler;
  /*
  https://stackoverflow.com/questions/29758674/how-do-you-unit-test-a-custom-exception-handler-in-php
  */
  class PapertrailErrorHandlerTests extends TestCase
  {
    public function test_OnException_Sender_IsCalled()
    {
      $errorHandler = new Papertrail_ErrorHandler();

      $fakeSender = $this->getMockBuilder('PapertrailForWP\Papertrail_Sender')
                        ->getMock();

      $fakeSender->expects($this->exactly(1))
                ->method('send_remote_syslog')
                ->with($this->stringContains("[ERROR] test exception"), 'system', 'program', 'host', 'port');

      $errorHandler->papertrailSender = $fakeSender;

      try{
      $errorHandler->exception_handler(new \Exception('test exception'));
      }catch(\Exception $e){
        //Catch the retrown exception otherwise the test will fail
      }
    }

    public function test_OnError_Sender_IsCalled()
    {
      $errorHandler = new Papertrail_ErrorHandler();

      $fakeSender = $this->getMockBuilder('PapertrailForWP\Papertrail_Sender')
                        ->getMock();

      $fakeSender->expects($this->exactly(1))
                ->method('send_remote_syslog')
                ->with("[ERROR] string test.php test", 'system', 'program', 'host', 'port');

      $errorHandler->papertrailSender = $fakeSender;
      $errorHandler->error_handler(1 , "string", "test.php", "test");
    }

    public function test_OnError_returns_false()
    {
      $errorHandler = new Papertrail_ErrorHandler();

      $fakeSender = $this->getMockBuilder('PapertrailForWP\Papertrail_Sender')
                        ->getMock();

      $errorHandler->papertrailSender = $fakeSender;
      $result = $errorHandler->error_handler(1 , "string", "test.php", "test");
      
      $this->assertFalse($result);
    }

    public function test_OnException_Exception_IsReThrown()
    {
      $errorHandler = new Papertrail_ErrorHandler();
      $fakeSender = $this->getMockBuilder('PapertrailForWP\Papertrail_Sender')->getMock();
      $errorHandler->papertrailSender = $fakeSender;

      $this->expectExceptionMessage('test exception');

      $errorHandler->exception_handler(new \Exception('test exception'));
    }

    public function test_SetHandler_SetsExceptionHandler()
    {
      $errorHandler = new Papertrail_ErrorHandler();
      $errorHandler->setup_handler();
      
      $myExceptionHandler = set_exception_handler(null);

      $this->assertNotNull($myExceptionHandler);
    }

    public function test_SetHandler_SetsErrorHandler()
    {
      $errorHandler = new Papertrail_ErrorHandler();
      $errorHandler->setup_handler();
      
      $myErrorHandler = set_error_handler(null);

      $this->assertNotNull($myErrorHandler);
    }
  }
}
namespace {
    // global namespace.
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
}
