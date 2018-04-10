<?php
declare(strict_types = 1);

/**
 * @copyright Copyright (c) 2015 Slevomat.cz, s.r.o.
 * @license   https://github.com/slevomat/coding-standard/blob/master/LICENSE.md MIT Licence
 */


namespace NocWorx\Helpers;

class PropertyHelper
{

	public static function isProperty(\PHP_CodeSniffer\Files\File $codeSnifferFile, int $variablePointer): bool
	{
		$propertyDeterminingPointer = TokenHelper::findPreviousExcluding(
			$codeSnifferFile,
			array_merge([T_STATIC], TokenHelper::$ineffectiveTokenCodes),
			$variablePointer - 1
		);

		return in_array($codeSnifferFile->getTokens()[$propertyDeterminingPointer]['code'], [
			T_PRIVATE,
			T_PROTECTED,
			T_PUBLIC,
			T_VAR,
		], true);
	}

	public static function getFullyQualifiedName(\PHP_CodeSniffer\Files\File $codeSnifferFile, int $propertyPointer): string
	{
		$propertyToken = $codeSnifferFile->getTokens()[$propertyPointer];
		$propertyName = $propertyToken['content'];

		$classPointer = array_reverse(array_keys($propertyToken['conditions']))[0];
		if ($codeSnifferFile->getTokens()[$classPointer]['code'] === T_ANON_CLASS) {
			return sprintf('class@anonymous::%s', $propertyName);
		}

		$name = sprintf('%s%s::%s', NamespaceHelper::NAMESPACE_SEPARATOR, ClassHelper::getName($codeSnifferFile, $classPointer), $propertyName);
		$namespace = NamespaceHelper::findCurrentNamespaceName($codeSnifferFile, $propertyPointer);
		return $namespace !== null ? sprintf('%s%s%s', NamespaceHelper::NAMESPACE_SEPARATOR, $namespace, $name) : $name;
	}

}
