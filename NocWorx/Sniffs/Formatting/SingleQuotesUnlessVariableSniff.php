<?php
namespace NocWorx\Sniffs\Formatting;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class SingleQuotesUnlessVariableSniff implements Sniff
{

  /**
   * Returns the token types that this sniff is interested in.
   *
   * @return array(int)
   */
  public function register() {
    return [T_CONSTANT_ENCAPSED_STRING];
  }//end register()


  /**
   * Processes this sniff, when one of its tokens is encountered.
   *
   * @param \PHP_CodeSniffer\Files\File $phpcsFile The current file being
   *  checked.
   * @param int $stackPtr The position of the current token in the
   *  stack passed in $tokens.
   *
   * @return void
   */
  public function process(File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();

    if ($tokens[$stackPtr]['type'] === 'T_CONSTANT_ENCAPSED_STRING') {

      // if it starts with a double quote
      if (substr($tokens[$stackPtr]['content'], 0, 1) === '"') {

        // ...and contains a single quote, we're good.
        if (strpos($tokens[$stackPtr]['content'] , "'")) {
          return;
        }
        // ...or contains an escaped character, we're good
        if ($this->_containsEscapedChrs($tokens[$stackPtr]['content'])) {
          return;
        }

        // Otherwise, it's an error.
        $error = 'Only use Double Quotes when a variable is being ' .
        'inserted.';
        $data = [trim($tokens[$stackPtr]['content'])];

        $phpcsFile->addError(
          $error,
          $stackPtr,
          'FOUND',
          $data
        );
      }
    }
  }

  /**
   * Check the string for escaped characters
   *
   * @param string $content the content to check
   * @return bool
   */

  protected function _containsEscapedChrs(string $content) : bool {
    $allowedChrs = [
      '\0',
      '\1',
      '\2',
      '\3',
      '\4',
      '\5',
      '\6',
      '\7',
      '\n',
      '\r',
      '\f',
      '\t',
      '\v',
      '\x',
      '\b',
      '\e',
      '\u',
      '\'',
      '\"',
    ];

    foreach($allowedChrs as $testChar) {
      if ((strpos($content, $testChar) !== false)) {
        /*
         * Line ends are tricky. We don't want to trigger on a line ending
         * in \" becase we aren't escaping the last chr.
         */
        if (strpos($content, $testChar) === (strlen($content) - 2) ) {
          return false;
        }

        return true;
      }
    }

    return false;

  }
}
