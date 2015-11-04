<?php
/**
 * Test code
 */

/**
 * Comments
 */
class Comments {

  /**
   * My constant
   */
  const MISSING = '';

  /**
   * My private var
   * @var string
   */
  private $_missing;

  /**
   * No params
   *
   * @param string $hi Greeting message
   * @param string $there
   */
  public function noParams($hi, $there) {
    go($hi, $there);
  }

  /**
   * No return
   *
   * @return string
   */
  public function noReturn() {
    return 'hi';
  }

  /**
   * No throws
   *
   * @throws Exception
   */
  public function noThrows() {
    throw new Exception();
  }

  /**
   * Not needed
   */
  public function paramsNotNeeded() {
    // hi
  }

  /**
   * Wrong order
   *
   * @param string $hi
   * @param string $there
   * @return string
   * @throws Exception
   */
  public function wrongOrderThrows($hi, $there) {
    if (empty($there)) {
      throw new Exception();
    }
    
    return $hi;
  }
}
