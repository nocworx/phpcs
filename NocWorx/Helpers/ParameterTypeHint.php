<?php
declare(strict_types = 1);

/**
 * @copyright Copyright (c) 2015 Slevomat.cz, s.r.o.
 * @license   https://github.com/slevomat/coding-standard/blob/master/LICENSE.md MIT Licence
 */

namespace NocWorx\Helpers;

class ParameterTypeHint
{

	/** @var string */
	private $typeHint;

	/** @var bool */
	private $nullable;

	/** @var bool */
	private $optional;

	public function __construct(
		string $typeHint,
		bool $nullable,
		bool $optional
	)
	{
		$this->typeHint = $typeHint;
		$this->nullable = $nullable;
		$this->optional = $optional;
	}

	public function getTypeHint(): string
	{
		return $this->typeHint;
	}

	public function isNullable(): bool
	{
		return $this->nullable;
	}

	public function isOptional(): bool
	{
		return $this->optional;
	}

}
