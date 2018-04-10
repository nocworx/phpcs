<?php
declare(strict_types = 1);
/**
 * @copyright Copyright (c) 2015 Slevomat.cz, s.r.o.
 * @license   https://github.com/slevomat/coding-standard/blob/master/LICENSE.md MIT Licence
 */

namespace NocWorx\Sniffs\TypeHints;

use NocWorx\Helpers\SniffSettingsHelper;
use NocWorx\Helpers\TokenHelper;

class ReturnTypeHintSpacingSniff implements \PHP_CodeSniffer\Sniffs\Sniff
{

	public const CODE_NO_SPACE_BETWEEN_COLON_AND_TYPE_HINT = 'NoSpaceBetweenColonAndTypeHint';

	public const CODE_MULTIPLE_SPACES_BETWEEN_COLON_AND_TYPE_HINT = 'MultipleSpacesBetweenColonAndTypeHint';

	public const CODE_NO_SPACE_BETWEEN_COLON_AND_NULLABILITY_SYMBOL = 'NoSpaceBetweenColonAndNullabilitySymbol';

	public const CODE_MULTIPLE_SPACES_BETWEEN_COLON_AND_NULLABILITY_SYMBOL = 'MultipleSpacesBetweenColonAndNullabilitySymbol';

	public const CODE_WHITESPACE_BEFORE_COLON = 'WhitespaceBeforeColon';

	public const CODE_INCORRECT_SPACES_BEFORE_COLON = 'IncorrectWhitespaceBeforeColon';

	public const CODE_WHITESPACE_AFTER_NULLABILITY_SYMBOL = 'WhitespaceAfterNullabilitySymbol';

	/** @var int */
	public $spacesCountBeforeColon = 1;

	/** @var bool */
	public $ignoreNewLines = true;
	
	/**
	 * @return mixed[]
	 */
	public function register(): array
	{
		return [
			T_RETURN_TYPE,
		];
	}

	/**
	 * @phpcsSuppress NocWorx.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile
	 * @param int $typeHintPointer
	 */
	public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $typeHintPointer): void
	{
		$tokens = $phpcsFile->getTokens();

		/** @var int $typeHintPointer */
		$typeHintPointer = TokenHelper::findPreviousExcluding($phpcsFile, [T_NS_SEPARATOR, T_STRING], $typeHintPointer - 1) + 1;
		/** @var int $colonPointer */
		$colonPointer = TokenHelper::findPreviousExcluding($phpcsFile, array_merge([T_NULLABLE], TokenHelper::$ineffectiveTokenCodes), $typeHintPointer - 1);

		$nextPointer = TokenHelper::findNextEffective($phpcsFile, $colonPointer + 1);
		$nullabilitySymbolPointer = $nextPointer !== null && $tokens[$nextPointer]['code'] === T_NULLABLE ? $nextPointer : null;

		if ($nullabilitySymbolPointer === null) {
			if ($tokens[$colonPointer + 1]['code'] !== T_WHITESPACE) {
				$fix = $phpcsFile->addFixableError('There must be exactly one space between return type hint colon and return type hint.', $typeHintPointer, self::CODE_NO_SPACE_BETWEEN_COLON_AND_TYPE_HINT);
				if ($fix) {
					$phpcsFile->fixer->beginChangeset();
					$phpcsFile->fixer->addContent($colonPointer, ' ');
					$phpcsFile->fixer->endChangeset();
				}
			} elseif (($this->ignoreNewLines && ord($tokens[$colonPointer +1]['content'])!==10) && $tokens[$colonPointer + 1]['content'] !== ' ') {
				$fix = $phpcsFile->addFixableError('There must be exactly one space between return type hint colon and return type hint. 3', $typeHintPointer, self::CODE_MULTIPLE_SPACES_BETWEEN_COLON_AND_TYPE_HINT);
				if ($fix) {
					$phpcsFile->fixer->beginChangeset();
					$phpcsFile->fixer->replaceToken($colonPointer + 1, ' ');
					$phpcsFile->fixer->endChangeset();
				}
			}
		} else {
			if ($tokens[$colonPointer + 1]['code'] !== T_WHITESPACE) {
				$fix = $phpcsFile->addFixableError('There must be exactly one space between return type hint colon and return type hint nullability symbol.', $typeHintPointer, self::CODE_NO_SPACE_BETWEEN_COLON_AND_NULLABILITY_SYMBOL);
				if ($fix) {
					$phpcsFile->fixer->beginChangeset();
					$phpcsFile->fixer->addContent($colonPointer, ' ');
					$phpcsFile->fixer->endChangeset();
				}
			} elseif ($tokens[$colonPointer + 1]['content'] !== ' ') {
				$fix = $phpcsFile->addFixableError('There must be exactly one space between return type hint colon and return type hint nullability symbol.', $typeHintPointer, self::CODE_MULTIPLE_SPACES_BETWEEN_COLON_AND_NULLABILITY_SYMBOL);
				if ($fix) {
					$phpcsFile->fixer->beginChangeset();
					$phpcsFile->fixer->replaceToken($colonPointer + 1, ' ');
					$phpcsFile->fixer->endChangeset();
				}
			}

			if ($nullabilitySymbolPointer + 1 !== $typeHintPointer) {
				$fix = $phpcsFile->addFixableError('There must be no whitespace between return type hint nullability symbol and return type hint.', $typeHintPointer, self::CODE_WHITESPACE_AFTER_NULLABILITY_SYMBOL);
				if ($fix) {
					$phpcsFile->fixer->beginChangeset();
					$phpcsFile->fixer->replaceToken($nullabilitySymbolPointer + 1, '');
					$phpcsFile->fixer->endChangeset();
				}
			}
		}

		$spacesCountBeforeColon = SniffSettingsHelper::normalizeInteger($this->spacesCountBeforeColon);
		$expectedSpaces = str_repeat(' ', $spacesCountBeforeColon);

		if (($tokens[$colonPointer - 1]['code'] !== T_CLOSE_PARENTHESIS && $tokens[$colonPointer - 1]['content'] !== $expectedSpaces)) {

			if ($spacesCountBeforeColon === 0) {
				$fix = $phpcsFile->addFixableError('There must be no whitespace between closing parenthesis and return type colon.', $typeHintPointer, self::CODE_WHITESPACE_BEFORE_COLON);
			} elseif ($this->ignoreNewLines && ord($tokens[$colonPointer -2]['content'])!==10) {
				// if there is a CR (ord()===10 then there will always be a whitespace. Thu the -2)
				$fix = $phpcsFile->addFixableError(
					sprintf('There must be exactly %d whitespace%s between closing parenthesis and return type colon. 1', $spacesCountBeforeColon, $spacesCountBeforeColon !== 1 ? 's' : ''),
					$typeHintPointer,
					self::CODE_INCORRECT_SPACES_BEFORE_COLON
				);
			}

			if (isset($fix) and !empty($fix)) {
				$phpcsFile->fixer->beginChangeset();
				$phpcsFile->fixer->replaceToken($colonPointer - 1, $expectedSpaces);
				$phpcsFile->fixer->endChangeset();
			}
		} elseif ( ($this->ignoreNewLines && ord($tokens[$colonPointer - 2]['content'])!==10) &&
			$tokens[$colonPointer - 1]['code'] === T_CLOSE_PARENTHESIS && $spacesCountBeforeColon !== 0) {
			$fix = $phpcsFile->addFixableError(
				sprintf('There must be exactly %d whitespace%s between closing parenthesis and return type colon. 2', $spacesCountBeforeColon, $spacesCountBeforeColon !== 1 ? 's' : ''),
				$typeHintPointer,
				self::CODE_INCORRECT_SPACES_BEFORE_COLON
			);
			if ($fix) {
				$phpcsFile->fixer->beginChangeset();
				$phpcsFile->fixer->addContent($colonPointer - 1, $expectedSpaces);
				$phpcsFile->fixer->endChangeset();
			}
		}
	}

}
