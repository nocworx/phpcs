<?php
/**
 * Test code
 */

/**
 * Something
 */
class Strings {

  /**
   * Quotes
   */
  public function quotes() {
    $a = 'Single quotes';
    $b = "Double quotes for {$a}";
    $c = "Also for {$this->callMe()}";
  }

  /**
   * Multiline strings
   */
  public function multiline() {
    $greeting = 'Hello mother. ' .
      'Hello father. Here I am at ' .
      "Camp {$name}.";
  }
}
