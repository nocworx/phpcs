<?php
declare(strict_types = 1);

/**
 * @copyright Copyright (c) 2015 Slevomat.cz, s.r.o.
 * @license   https://github.com/slevomat/coding-standard/blob/master/LICENSE.md MIT Licence
 */

namespace NocWorx\Helpers;

class CatchHelper
{

	/**
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile
	 * @param \NocWorx\Helpers\UseStatement[] $useStatements
	 * @param mixed[] $catchToken
	 * @return string[]
	 */
	public static function findCatchedTypesInCatch(\PHP_CodeSniffer\Files\File $phpcsFile, array $useStatements, array $catchToken): array
	{
		$nameEndPointer = $catchToken['parenthesis_opener'];
		$tokens = $phpcsFile->getTokens();
		$catchedTypes = [];
		do {
			$nameStartPointer = TokenHelper::findNext($phpcsFile, array_merge([T_BITWISE_OR], TokenHelper::$nameTokenCodes), $nameEndPointer + 1, $catchToken['parenthesis_closer']);
			if ($nameStartPointer === null) {
				break;
			}

			if ($tokens[$nameStartPointer]['code'] === T_BITWISE_OR) {
				/** @var int $nameStartPointer */
				$nameStartPointer = TokenHelper::findNextEffective($phpcsFile, $nameStartPointer + 1, $catchToken['parenthesis_closer']);
			}

			$pointerAfterNameEndPointer = TokenHelper::findNextExcluding($phpcsFile, TokenHelper::$nameTokenCodes, $nameStartPointer + 1);
			$nameEndPointer = $pointerAfterNameEndPointer === null ? $nameStartPointer : $pointerAfterNameEndPointer - 1;

			$catchedTypes[] = NamespaceHelper::resolveClassName(
				$phpcsFile,
				TokenHelper::getContent($phpcsFile, $nameStartPointer, $nameEndPointer),
				$useStatements,
				$catchToken['parenthesis_opener']
			);
		} while (true);

		return $catchedTypes;
	}

}
