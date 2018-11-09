<?php
/**
 * Ensures USE blocks are declared correctly.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace NocWorx\Sniffs\Formatting;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

class UseDeclarationSniff implements Sniff
{

  /**
   * Returns an array of tokens this test wants to listen for.
   *
   * @return array
   */
  public function register()
  {
      return [T_USE];

  }//end register()


  /**
   * Processes this test, when one of its tokens is encountered.
   *
   * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
   * @param int $stackPtr The position of the current token in the stack passed
   *                      in $tokens.
   *
   *
   * @return void
   */
  public function process(File $phpcsFile, $stackPtr) {
    if ($this->shouldIgnoreUse($phpcsFile, $stackPtr) === true) {
      return;
    }

    $tokens = $phpcsFile->getTokens();

    // No leading backslash
    if ($tokens[($stackPtr + 2)]['type'] === 'T_NS_SEPARATOR') {
      $error = 'There must not be a leading \ before a namespace.';
      $fix = $phpcsFile->addError(
        $error,
        $stackPtr,
        'BackslashBeforeNamespace'
      );
    }
  }

    /**
     * Check if this use statement is part of the namespace block.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int $stackPtr The position of the current token in the stack
     *                      passed in $tokens.
     *
     * @return void
     */
    private function shouldIgnoreUse($phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // Ignore USE keywords inside closures and during live coding.
        $next = $phpcsFile->findNext(
          Tokens::$emptyTokens,
          ($stackPtr + 1),
          null,
          true
        );
        if ($next === false || $tokens[$next]['code'] === T_OPEN_PARENTHESIS) {
            return true;
        }

        // Ignore USE keywords for traits.
        if ($phpcsFile->hasCondition($stackPtr, [T_CLASS, T_TRAIT]) === true) {
            return true;
        }

        return false;

    }//end shouldIgnoreUse()


}