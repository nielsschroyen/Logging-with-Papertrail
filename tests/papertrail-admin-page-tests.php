<?php
require_once './php/papertrail-admin-page.php';
use PHPUnit\Framework\TestCase;

class PapertrailAdminPageTests extends TestCase
{
  public function test_papertrail_for_wordpress_ThrowsException()
  {    
    $this->expectExceptionMessage('Papertrail for WordPress error test');
    $adminPage = new PapertrailAdminPage();

    $adminPage->test_papertrail_for_wordpress();
  }
}

function add_action(){
  //Stub global function
}