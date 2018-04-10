<?php
declare(strict_types = 1);

/**
 * @copyright Copyright (c) 2015 Slevomat.cz, s.r.o.
 * @license   https://github.com/slevomat/coding-standard/blob/master/LICENSE.md MIT Licence
 */

namespace NocWorx\Helpers;

class TokenPointerOutOfBoundsException extends \Exception
{

	/** @var int */
	private $pointer;

	/** @var int */
	private $lastTokenPointer;

	public function __construct(int $pointer, int $lastTokenPointer, ?\Throwable $previous = null)
	{
		parent::__construct(
			sprintf(
				'Attempted access to token pointer %d, last token pointer is %d',
				$pointer,
				$lastTokenPointer
			),
			0,
			$previous
		);

		$this->pointer = $pointer;
		$this->lastTokenPointer = $lastTokenPointer;
	}

	public function getPointer(): int
	{
		return $this->pointer;
	}

	public function getLastTokenPointer(): int
	{
		return $this->lastTokenPointer;
	}

}
