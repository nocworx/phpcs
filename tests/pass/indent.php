<?php
/**
 * Test code
 */

/**
 * Something
 */
class Indent {

  /**
   * If blocks
   */
  public function ifBlock() {
    if ($this->test()) {
      die('first');
    }

    if ($this->test()) {
      die('second');
    }
  }

  /**
   * Too little
   */
  public function tooLittle() {
    return 'should be 2 spaces';
  }

  /**
   * Too much
   */
  public function tooMuch() {
    return 'should be 2 spaces';
  }

  /**
   * Switch blocks
   */
  public function switchBlock() {
    switch (false) {
      case 'a':
        echo 'a';
        break;

      case 'b':
        echo 'b';
        break;

      case 'c':
        echo 'c';
        break;
    }
  }


  /**
   * Closing brace indenting
   */
  public function closingBrace() {
    if ($this->test()) {
      echo 'whatever';
    }
  }
}
