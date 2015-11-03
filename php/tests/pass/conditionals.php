<?php
/**
 * Test code
 */

/**
 * Something
 */
class Conditionals {

  /**
   * Elseif
   */
  public function elseifOneWord() {
    if ($this->test()) {
      $test = 'yes';
    } elseif ($this->test()) {
      $test = 'no';
    }
  }

  /**
   * Strict compare
   */
  public function identical() {
    if ($one === $two) {
      $test = 'yes';
    }

    if ($one !== $two) {
      $test = 'yes';
    }
  }

  /**
   * All conditionals must evaluate to boolean
   */
  public function boolCompare() {
    if (true !== $one) {
      $test = 'yes';
    }

    $two = true;
    if ($two) {
      $test = 'yes';
    }
  }

  /**
   * Assigning in the compare must be wrapped in ()
   */
  public function assign() {
    while (false !== ($row = fgetcsv($file))) {
      $test = 'yes';
    }
  }

  /**
   * Ternary
   */
  public function ternary() {
    $result = ($num > 5) ? true : false;
    $ultimate_result = ($result) ? 'yes' : 'no';

    $result = ('yes' === $ultimate_result) ?
      $this->getSomeMagicPlease() :
      $this->getTheFailureMessage();

    return ('yes' === $ultimate_result) ?
      $this->getSomeMagicPlease() :
      $this->getTheFailureMessage();
  }
}
