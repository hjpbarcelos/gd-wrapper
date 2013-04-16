<?php
/**
 * Defines Reader interface.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

/**
 * Represents an input "device" to resources.
 */
interface Reader
{
	/**
	 * Creates an image resource based on a filepath.
	 *
	 * @param string $path The path to a valid image.
	 *
	 * @return \GdWrapper\Resource\Resource A new Resource object.
	 *
	 * @throws \GdWrapper\Io\Exception If cannot read from file system
	 * @throws \InvalidArgumentException If `$path` does not point to a valid file.
	 */
	public function read($path);
}
