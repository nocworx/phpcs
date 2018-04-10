<?php
declare(strict_types = 1);

/**
 * @copyright Copyright (c) 2015 Slevomat.cz, s.r.o.
 * @license   https://github.com/slevomat/coding-standard/blob/master/LICENSE.md MIT Licence
 */

namespace NocWorx\Helpers;

class SuppressHelper
{

	public const ANNOTATION = '@phpcsSuppress';

	public static function isSniffSuppressed(\PHP_CodeSniffer\Files\File $codeSnifferFile, int $pointer, string $suppressName): bool
	{
		return array_reduce(AnnotationHelper::getAnnotationsByName($codeSnifferFile, $pointer, self::ANNOTATION), function (bool $carry, Annotation $annotation) use ($suppressName): bool {
			if ($annotation->getContent() === $suppressName || strpos($suppressName, sprintf('%s.', $annotation->getContent())) === 0) {
				$carry = true;
			}
			return $carry;
		}, false);
	}

}
