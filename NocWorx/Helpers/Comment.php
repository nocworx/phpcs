<?php
declare(strict_types = 1);

/**
 * @copyright Copyright (c) 2015 Slevomat.cz, s.r.o.
 * @license   https://github.com/slevomat/coding-standard/blob/master/LICENSE.md MIT Licence
 */

namespace NocWorx\Helpers;

class Comment
{

	/** @var int */
	private $pointer;

	/** @var string */
	private $content;

	public function __construct(int $pointer, string $content)
	{
		$this->pointer = $pointer;
		$this->content = $content;
	}

	public function getPointer(): int
	{
		return $this->pointer;
	}

	public function getContent(): string
	{
		return $this->content;
	}

}
