<?php
declare(strict_types = 1);

/**
 * @copyright Copyright (c) 2015 Slevomat.cz, s.r.o.
 * @license   https://github.com/slevomat/coding-standard/blob/master/LICENSE.md MIT Licence
 */

namespace NocWorx\Helpers;

class TypeHintHelper
{

	public static function isSimpleTypeHint(string $typeHint): bool
	{
		return in_array($typeHint, self::getSimpleTypeHints(), true);
	}

	public static function isSimpleIterableTypeHint(string $typeHint): bool
	{
		return in_array($typeHint, self::getSimpleIterableTypeHints(), true);
	}

	public static function convertLongSimpleTypeHintToShort(string $typeHint): string
	{
		$longToShort = [
			'integer' => 'int',
			'boolean' => 'bool',
		];
		return array_key_exists($typeHint, $longToShort) ? $longToShort[$typeHint] : $typeHint;
	}

	public static function getFullyQualifiedTypeHint(\PHP_CodeSniffer\Files\File $phpcsFile, int $pointer, string $typeHint): string
	{
		if (self::isSimpleTypeHint($typeHint)) {
			return self::convertLongSimpleTypeHintToShort($typeHint);
		}

		/** @var int $openTagPointer */
		$openTagPointer = TokenHelper::findPrevious($phpcsFile, T_OPEN_TAG, $pointer);
		$useStatements = UseStatementHelper::getUseStatements($phpcsFile, $openTagPointer);
		return NamespaceHelper::resolveClassName($phpcsFile, $typeHint, $useStatements, $pointer);
	}

	/**
	 * @return string[]
	 */
	public static function getSimpleTypeHints(): array
	{
		static $simpleTypeHints;

		if ($simpleTypeHints === null) {
			$simpleTypeHints = [
				'int',
				'integer',
				'float',
				'string',
				'bool',
				'boolean',
				'callable',
				'self',
				'array',
				'iterable',
				'void',
			];
		}

		return $simpleTypeHints;
	}

	/**
	 * @return string[]
	 */
	public static function getSimpleIterableTypeHints(): array
	{
		return [
			'array',
			'iterable',
		];
	}

	public static function isSimpleUnofficialTypeHints(string $typeHint): bool
	{
		static $simpleUnofficialTypeHints;

		if ($simpleUnofficialTypeHints === null) {
			$simpleUnofficialTypeHints = [
				'null',
				'mixed',
				'true',
				'false',
				'object',
				'resource',
				'static',
				'$this',
			];
		}

		return in_array($typeHint, $simpleUnofficialTypeHints, true);
	}

}
