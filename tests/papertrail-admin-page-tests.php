<?php
namespace Tests{
  require_once './php/papertrail-admin-page.php';
  use PHPUnit\Framework\TestCase;
  use PapertrailForWP\PapertrailAdminPage;
  use phpmock\MockBuilder;
  
  class PapertrailAdminPageTests extends TestCase
  {
    public static $isAdmin;

    public function test_papertrail_for_wordpress_ThrowsException()
    {    
      $this->expectExceptionMessage('Papertrail for WordPress error test');
      $adminPage = new PapertrailAdminPage();

      $adminPage->test_papertrail_for_wordpress();
    }

    public function test_init_admin_page_when_not_admin_ReturnNull()
    {  
      self::$isAdmin = false;  
      $adminPage = PapertrailAdminPage::init_admin_page();
      $this->assertNull($adminPage);

    }

    public function test_init_admin_page_when_admin_ReturnsAdminPage()
    {  
      self::$isAdmin = true;  
      $adminPage = PapertrailAdminPage::init_admin_page();
      $this->assertNotNull($adminPage);
    }

    public function test_create_admin_page_OutputsSettingsWrapper(){
      $adminPage = new PapertrailAdminPage();
      ob_start();
      $adminPage->create_admin_page();
      $settingsWrapper = ob_get_clean();
      $this->assertContains('<h1>Papertrail for WordPress</h1>',$settingsWrapper);
      $this->assertContains('<form method="post" action="options.php">',$settingsWrapper);
    }

    public function test_page_init_hooksup_settings(){
       $adminPage = new PapertrailAdminPage();
       $adminPage->page_init();
       $this->assertEquals(4,count($this->add_settings_calls));
       $this->assertEquals("host",$this->add_settings_calls[0]);
       $this->assertEquals("port",$this->add_settings_calls[1]);
       $this->assertEquals("system",$this->add_settings_calls[2]);
       $this->assertEquals("program",$this->add_settings_calls[3]);
    }

    protected function setUp()
    {
      //MOCKOUT stream_socket_client fwrite fclose
      $this->add_settings_calls = array();
    
      $builder = new MockBuilder();
      $this->add_setting_field_mock = $builder->setNamespace("PapertrailForWP")
                                  ->setName('add_settings_field')
                                  ->setFunction( function($name) {array_push ($this->add_settings_calls,$name);})
                                  ->build();

      $this->add_setting_field_mock->enable();
    }
    protected function tearDown()
    {
      $this->add_setting_field_mock->disable();
    }
  }
}

namespace {
    // global namespace.

  function is_admin(){
    return Tests\PapertrailAdminPageTests::$isAdmin;
  }

  function add_action(){
    
  }

  function settings_fields(){

  }

  function  do_settings_sections(){
    
  }

  function submit_button(){

  }

  function register_setting(){
    
  }
  function add_settings_section(){
    
  }
}

