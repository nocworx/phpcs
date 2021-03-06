<?php
declare(strict_types = 1);

/**
 * @copyright Copyright (c) 2015 Slevomat.cz, s.r.o.
 * @license   https://github.com/slevomat/coding-standard/blob/master/LICENSE.md MIT Licence
 */

namespace NocWorx\Helpers;

class UseStatement
{

	public const TYPE_DEFAULT = ReferencedName::TYPE_DEFAULT;
	public const TYPE_FUNCTION = ReferencedName::TYPE_FUNCTION;
	public const TYPE_CONSTANT = ReferencedName::TYPE_CONSTANT;

	/** @var string */
	private $nameAsReferencedInFile;

	/** @var string */
	private $normalizedNameAsReferencedInFile;

	/** @var string */
	private $fullyQualifiedTypeName;

	/** @var int */
	private $usePointer;

	/** @var string */
	private $type;

	public function __construct(
		string $nameAsReferencedInFile,
		string $fullyQualifiedClassName,
		int $usePointer,
		string $type
	)
	{
		$this->nameAsReferencedInFile = $nameAsReferencedInFile;
		$this->normalizedNameAsReferencedInFile = self::normalizedNameAsReferencedInFile($type, $nameAsReferencedInFile);
		$this->fullyQualifiedTypeName = $fullyQualifiedClassName;
		$this->usePointer = $usePointer;
		$this->type = $type;
	}

	public static function getUniqueId(string $type, string $name): string
	{
		$normalizedName = self::normalizedNameAsReferencedInFile($type, $name);

		if ($type === self::TYPE_DEFAULT) {
			return $normalizedName;
		}

		return sprintf('%s %s', $type, $normalizedName);
	}

	public static function normalizedNameAsReferencedInFile(string $type, string $name): string
	{
		if ($type === self::TYPE_CONSTANT) {
			return $name;
		}

		return strtolower($name);
	}

	public function getNameAsReferencedInFile(): string
	{
		return $this->nameAsReferencedInFile;
	}

	public function getCanonicalNameAsReferencedInFile(): string
	{
		return $this->normalizedNameAsReferencedInFile;
	}

	public function getFullyQualifiedTypeName(): string
	{
		return $this->fullyQualifiedTypeName;
	}

	public function getPointer(): int
	{
		return $this->usePointer;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function isConstant(): bool
	{
		return $this->type === self::TYPE_CONSTANT;
	}

	public function isFunction(): bool
	{
		return $this->type === self::TYPE_FUNCTION;
	}

	public function hasSameType(self $that): bool
	{
		return $this->type === $that->type;
	}

	public static function getTypeName(string $type): ?string
	{
		if ($type === self::TYPE_CONSTANT) {
			return 'const';
		}

		if ($type === self::TYPE_FUNCTION) {
			return 'function';
		}

		return null;
	}

}
