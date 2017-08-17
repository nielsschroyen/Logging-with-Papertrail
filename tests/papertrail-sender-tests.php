<?php
namespace Test;
require_once './php/papertrail-sender.php';
use PHPUnit\Framework\TestCase;
use phpmock\MockBuilder;
use PapertrailForWP\Papertrail_Sender;

class PapertrailSenderTests extends TestCase
{
  public function test_send_remote_syslog_within_function_Exceptions_are_catched_and_eaten()
  {
    $sender = new Papertrail_Sender;
    $this->fwriteMock->disable();
    
    $builder = new MockBuilder();
    $this->fwriteMock = $builder->setNamespace("PapertrailForWP")
                                ->setName('fwrite')
                                ->setFunction(function() {throw new \Exception("test");})
                                ->build();
    $this->fwriteMock->enable();
    $sender->send_remote_syslog("udp","message", "system", "program", "papertrailurl", "papertrailPort");

    $this->assertTrue(true);
  }

   
  public function test_send_remote_syslog_callsstreamSocket_fwrite_fclose()
  {
    $sender = new Papertrail_Sender;
    $sender->send_remote_syslog("udp","message", "system", "program", "papertrailurl", "papertrailPort");

    $this->assertEquals(1, $this->stream_socket_called);
    $this->assertEquals(1, $this->fwrite_called);
    $this->assertEquals(1, $this->fclose_called);
  }
  
  protected function setUp()
  {
    //MOCKOUT stream_socket_client fwrite fclose
    $this->stream_socket_called = 0;
    $this->fwrite_called = 0;
    $this->fclose_called = 0;

    $builder = new MockBuilder();
    $this->streamMock = $builder->setNamespace("PapertrailForWP")
                                ->setName('stream_socket_client')
                                ->setFunction( function() {$this->stream_socket_called ++;})
                                ->build();
    $this->streamMock->enable();

    $builder = new MockBuilder();
    $this->fwriteMock = $builder->setNamespace("PapertrailForWP")
                                ->setName('fwrite')
                                ->setFunction(function() {$this->fwrite_called ++;})
                                ->build();
    $this->fwriteMock->enable();

    $builder = new MockBuilder();
    $this->fcloseMock = $builder->setNamespace("PapertrailForWP")
                                ->setName('fclose')
                                ->setFunction(function() {$this->fclose_called ++;})
                                ->build();
    $this->fcloseMock->enable();
  }
  
  protected function tearDown()
  {
    $this->streamMock->disable();
    $this->fwriteMock->disable();
    $this->fcloseMock->disable();
  }
}