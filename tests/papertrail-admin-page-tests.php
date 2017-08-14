<?php
namespace Tests{
  require_once './php/papertrail-admin-page.php';
  use PHPUnit\Framework\TestCase;
  use PapertrailForWP\PapertrailAdminPage; 

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
}

