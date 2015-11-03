<?php
/**
 * Test code
 */

/**
 * Something
 */
class Brace {

  /**
   * Open on new line
   */
  public function newLine() {
    return 'hi';
  }

  /**
   * Open on the same line and start the code
   */
  public function sameLineAndStart() {
    return 'hi';
  }

  /**
   * Opening brace rules
   */
  public function openingBrace() {
    if ($this->test()) {
      echo 'same line';
    }

    if ($this->test()) {
      echo 'blank line';
    }
  }

  /**
   * Closing brace rules
   */
  public function closingBrace() {
    if ($this->test()) {
      echo 'hi';
    }

    if ($this->test()) {
      echo 'false';
    } else {
      echo 'else';
    }

    if ($this->test()) {
      echo 'false';
    } elseif ($this->test()) {
      echo 'elseif';
    } else {
      echo 'end';
    }

    do {
      echo 'loop';
    } while ($this->test());
  }

  /**
   * Function definition on multiple lines
   *
   * @param string $apple
   * @param string $banana
   * @param string $carrot
   */
  public function manyArguments(
    $apple,
    $banana,
    $carrot
  ) {
    // done
  }

  /**
   * Multiline function call
   * @todo sniff isn't right for this. Might be checking 4 spaces.
   */
  public function callMultiLine() {
    $this->callSomething(
      $apple,
      $banana,
      $carrot
    );
  }

  /**
   * Always contain blocks
   */
  public function alwaysContainBlocks() {
    if ($this->test()) {
      echo 'yes';
    }
  }
}
