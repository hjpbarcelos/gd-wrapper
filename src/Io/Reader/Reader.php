<?php
/**
 * Defines Reader interface.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Io\Reader;

/**
 * Represents an input "device" to resources.
 */
interface Reader
{
	/**
	 * Creates an image resource based on a filepath.
	 *
	 * @param string $pathName The path to a valid image.
	 *
	 * @return resource A GD2 image resource.
	 *
	 * @throws Hjpbarcelos\GdWrapper\Io\Exception If cannot read from file system
	 * @throws \InvalidArgumentException If `$pathName` does not point to a valid file.
	 */
	public function read($pathName);
}
