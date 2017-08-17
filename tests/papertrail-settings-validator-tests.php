<?php
namespace Test;
require_once './php/papertrail-settings-validator.php';
use PHPUnit\Framework\TestCase;
use PapertrailForWP\PapertrailSettingsValidator;

class PapertrailSettingsValidatorTests extends TestCase{

  public function test_validate_HostEmpty_ReturnsError(){
    $settings=$this->create_valid_settings();
    $settings["host"] = "";

    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();

    $this->assertEquals(1,count($errors));
  }

  public function test_validate_HostNotSet_ReturnsError(){
    $settings=$this->create_valid_settings();
    unset($settings["host"]);

    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();  

    $this->assertEquals(1,count($errors));
  }

  public function test_validate_HostSet_NoError(){ 
    $settings=$this->create_valid_settings();
    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();
    $this->assertEquals(0,count($errors));
  }

  public function test_validate_PortEmpty_ReturnsError(){
    $settings=$this->create_valid_settings();
    $settings["port"] = "";

    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();
    
    $this->assertEquals(1,count($errors));
  }

  public function test_validate_PortNotSet_ReturnsError(){
    $settings=$this->create_valid_settings();
    unset($settings["port"]);

    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();  

    $this->assertEquals(1,count($errors));
  }

  public function test_validate_PortSet_NoError(){ 
    $settings=$this->create_valid_settings();
    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();
    $this->assertEquals(0,count($errors));
  }

  public function test_validate_SystemEmpty_ReturnsError(){
    $settings=$this->create_valid_settings();
    $settings["system"] = "";

    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();
    
    $this->assertEquals(1,count($errors));   
  }

  public function test_validate_SystemNotSet_ReturnsError(){
    $settings=$this->create_valid_settings();
    unset($settings["system"]);

    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();  

    $this->assertEquals(1,count($errors));
  }

  public function test_validate_SystemSet_NoError(){ 
    $settings=$this->create_valid_settings();

    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();
    
    $this->assertEquals(0,count($errors));
  }

    public function test_validate_ProgramEmpty_ReturnsError(){
    $settings=$this->create_valid_settings();
    $settings["program"] = "";

    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();
    
    $this->assertEquals(1,count($errors));   
  }

  public function test_validate_ProgramNotSet_ReturnsError(){
    $settings=$this->create_valid_settings();
    unset($settings["program"]);

    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();  

    $this->assertEquals(1,count($errors));
  }

  public function test_validate_ProgramSet_NoError(){ 
    $settings=$this->create_valid_settings();

    $validator = new PapertrailSettingsValidator($settings);
    $errors = $validator->validate();
    
    $this->assertEquals(0,count($errors));
  }

  public function test_is_valid_ValidSettings_ReturnsTrue(){ 
    $settings=$this->create_valid_settings();

    $validator = new PapertrailSettingsValidator($settings);
    
    $this->assertTrue($validator->is_valid());
  }

  public function test_is_valid_NotValidSettings_ReturnsFalse(){ 
    $settings=$this->create_valid_settings();
    $settings["host"] = "";

    $validator = new PapertrailSettingsValidator($settings);
    
    $this->assertFalse($validator->is_valid());
  }

  private function create_valid_settings(){
    return ["host"=>"Test",
            "port"=>"Test",
            "system"=>"Test",
            "program"=>"Test",
            "protocol"=>"udp"];
  }

  protected function setUp(){
      set_error_handler(null);
      set_exception_handler(null);
  }
}