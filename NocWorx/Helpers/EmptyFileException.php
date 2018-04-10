<?php
declare(strict_types = 1);

/**
 * @copyright Copyright (c) 2015 Slevomat.cz, s.r.o.
 * @license   https://github.com/slevomat/coding-standard/blob/master/LICENSE.md MIT Licence
 */

namespace NocWorx\Helpers;

class EmptyFileException extends \Exception
{

	/** @var string */
	private $filename;

	public function __construct(string $filename, ?\Throwable $previous = null)
	{
		parent::__construct(sprintf(
			'File %s is empty',
			$filename
		), 0, $previous);

		$this->filename = $filename;
	}

	public function getFilename(): string
	{
		return $this->filename;
	}

}
