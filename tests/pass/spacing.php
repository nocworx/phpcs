<?php
/**
 * Test code
 */

/**
 * Something
 */
class Spacing {

  /**
   * Spacing around operators
   */
  public function operators() {
    $one = $two;
    $one = ['key' => 'val'];
    if ($one === $two) {
      return;
    }

    // one blank line is good
    $one = $two . $three;
    $one = (! $two) ? $three : '';

    $one | $two & $three;
  }

  /**
   * Spacing around the comma separator
   */
  public function commaSeparator() {
    $one = ['a', 'b', 'c'];

    $one = [
      'a',
      'b',
      'c'
    ];
  }

  /**
   * Hug the parens
   */
  public function hugs() {
    trim($name);
    trim($name, '-');

    $this->callMe('sometime');
  }
}
