<?php
namespace Tests{
  require_once './php/papertrail-admin-page.php';
  use PHPUnit\Framework\TestCase;
  use PapertrailForWP\PapertrailAdminPage;
  use phpmock\MockBuilder;
  use FakeWP;

  
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

    public function test_strip_https_strips_http_from_begin(){
      $adminPage = new PapertrailAdminPage();
      $result = $adminPage->strip_https("http://www.google.com");
      $this->assertEquals("www.google.com", $result);
    }
    
    public function test_strip_https_strips_https_from_begin(){
      $adminPage = new PapertrailAdminPage();
      $result = $adminPage->strip_https("https://www.google.com");
      $this->assertEquals("www.google.com", $result);
    }

    public function test_strip_https_not_strips_http_from_end(){
            $adminPage = new PapertrailAdminPage();
      $result = $adminPage->strip_https("www.google.comhttp://");
      $this->assertEquals("www.google.comhttp://", $result);

    }

    public function test_strip_https_not_strips_http_from_middle(){
      $adminPage = new PapertrailAdminPage();
      $result = $adminPage->strip_https("www.http://google.com");
      $this->assertEquals("www.http://google.com", $result);
    }

    
    public function test_sanitize_InvalidValues_RestoresPrevious(){
        $adminPage = new PapertrailAdminPage();
        $sanitizedValues = $adminPage->sanitize([]);        
        $this->assertEquals(4, count($sanitizedValues));
    }

    public function test_host_callback_ReturnsInput(){
      $adminPage = new PapertrailAdminPage();
      ob_start();
      $adminPage->host_callback();
      $result = ob_get_clean();
      $this->assertContains('<input type="text" id="host" name="papertrail_for_wordpress_options[host]" value="" />',$result);
    }

    public function test_system_callback_ReturnsInput(){
      $adminPage = new PapertrailAdminPage();
      ob_start();
      $adminPage->system_callback();
      $result = ob_get_clean();
      $this->assertContains('<input type="text" id="system" name="papertrail_for_wordpress_options[system]" value=""',$result);
    }

    public function test_port_callback_ReturnsInput(){
      $adminPage = new PapertrailAdminPage();
      ob_start();
      $adminPage->port_callback();
      $result = ob_get_clean();
      $this->assertContains('<input type="text" id="port" name="papertrail_for_wordpress_options[port]" value="" />',$result);
    }

    
    public function test_program_callback_ReturnsInput(){
      $adminPage = new PapertrailAdminPage();
      ob_start();
      $adminPage->program_callback();
      $result = ob_get_clean();
      $this->assertContains('<input type="text" id="program" name="papertrail_for_wordpress_options[program]" value="" />',$result);
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
      FakeWP::setDefaults();
    }
    protected function tearDown()
    {
      $this->add_setting_field_mock->disable();
      FakeWP::setDefaults();
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

