<?php
/**
 * Test code
 */

/**
 * Something
 */
class Naming {
  
  /**
   * Hi
   */
  const HELLO = 'hi there';

  /**
   * Variable
   * @var string
   */
  protected $_something;

  /**
   * Variable
   * @var string
   */
  private $_another;

  /**
   * Variable
   * @var string
   */
  private $_even_more;

  /**
   * case
   */
  public function camelCase() {
    // yes
  }

  /**
   * case
   */
  protected function _camelCase() {
    // yes
  }

  /**
   * case
   */
  private function _privateCamelCase() {
    // yes
  }

  /**
   * Arrays
   */
  public function arrays() {
    $one = ['hi' => 'not'];
    $two = ['this_too' => 'noGood'];
  }

  /**
   * Vars
   */
  public function vars() {
    $not = 0;
    $no_way = 0;
    $stop_tt = 0;

    $apple = 'what is "a" supposed to mean?';
  }
}
