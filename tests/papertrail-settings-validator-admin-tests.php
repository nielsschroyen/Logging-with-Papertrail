<?php
namespace Test{
  require_once './php/papertrail-settings-admin-validator.php';

  use PHPUnit\Framework\TestCase;
  use PapertrailForWP\PapertrailSettingsAdminValidator;
  use PapertrailForWP\WPWrapper;

  class PapertrailSettingsValidatorAdminTests extends TestCase{

    public function test_validate_ValidSettings_ReturnsSameSettings(){
      $settings=$this->create_valid_settings(); 

      $validator = new PapertrailSettingsAdminValidator($settings,[]);
      $sanitizedFields = $validator->validate();
      
      $this->assertEquals(5,count($sanitizedFields));
      $this->assertEquals("TestHost",$sanitizedFields["host"]);
      $this->assertEquals("TestPort",$sanitizedFields["port"]);
      $this->assertEquals("TestSystem",$sanitizedFields["system"]);
      $this->assertEquals("TestProgram",$sanitizedFields["program"]);
      $this->assertEquals("udp",$sanitizedFields["protocol"]);
    }

    public function test_validate_InValidSettings_ReturnsRestoresOriginalIfPresent(){
      $settings=$this->create_valid_settings(); 
      $settings["host"] = "";

      $validator = new PapertrailSettingsAdminValidator($settings,["host"=>"originalHost"]);
      $sanitizedFields = $validator->validate();
      
      $this->assertEquals(5,count($sanitizedFields));
      $this->assertEquals("originalHost",$sanitizedFields["host"]);
    }

    public function test_validate_InValidSettings_OriginalNotPresent_UnsetsValue(){
      $settings=$this->create_valid_settings(); 
      $settings["host"] = "";

      $validator = new PapertrailSettingsAdminValidator($settings,[]);
      $sanitizedFields = $validator->validate();
      
      $this->assertEquals(4,count($sanitizedFields));
      $this->assertFalse(isset($sanitizedFields["host"]));
    }

    
    public function test_sanitization_GetsCalled_ForEachField(){
      $settings=$this->create_valid_settings(); 

      $validator = new PapertrailSettingsAdminValidator($settings,[]);

      $fakeWordpressWrapper = $this->getMockBuilder('PapertrailForWP\WPWrapper')
                          ->getMock();                        

      $fakeWordpressWrapper->expects($this->exactly(5))
                          ->method('sanitize_text_field')
                          ->with($this->logicalOr(
                                    $this->equalTo('TestHost'), 
                                    $this->equalTo('TestPort'), 
                                    $this->equalTo('TestSystem'), 
                                    $this->equalTo('TestProgram'),                                    
                                    $this->equalTo('udp')
                            ));

      WPWrapper::setInstanceForTest($fakeWordpressWrapper);

      $sanitizedFields = $validator->validate();
      
    }

    private function create_valid_settings(){
      return ["host"=>"TestHost",
              "port"=>"TestPort",
              "system"=>"TestSystem",
              "program"=>"TestProgram",
              "protocol"=>"udp"];
    }

    protected function setUp(){
        set_error_handler(null);
        set_exception_handler(null);
    }
  }
}
namespace {
  function sanitize_text_field($value){
    return $value;   
  }
  function add_settings_error(){
  }
}