<?php
require_once './php/php-utils.php';
use PHPUnit\Framework\TestCase;

class PhpUtilsTests extends TestCase
{
  public function test_array_any_EmptyArray_ReturnsFalse()
  {
    $this->assertFalse(array_any([], [$this, 'is_greater_than_five']));
  }

  public function test_array_any_OneElementNotOk_ReturnsFalse()
  {
    $this->assertFalse(array_any([2], [$this, 'is_greater_than_five']));
  }

  public function test_array_any_OneElementOk_ReturnsTrue()
  {
    $this->assertTrue(array_any([6], [$this, 'is_greater_than_five']));
  }

  public function test_array_any_OneElementNOk_OneElementOk_ReturnsTrue()
  {
    $this->assertTrue(array_any([2,6], [$this, 'is_greater_than_five']));
  }

  public function is_greater_than_five ($value){
    return $value > 5;
  }
}